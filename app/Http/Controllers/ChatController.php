<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\KanbanTask;
use App\Models\KanbanColumn;
use App\Models\User;

class ChatController extends Controller
{
    public function ask(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'message' => 'required|string|max:2000',
            ]);

            $user = auth()->user();

            if (!$user) {
                return response()->json(['reply' => 'يرجى تسجيل الدخول أولاً.']);
            }

            $userMessage = trim($request->input('message'));

            // Build DB snapshot and call Groq with full context
            $aiReply = $this->callGroqApi($userMessage, $user);

            if ($aiReply) {
                return response()->json(['reply' => $aiReply]);
            }

            return response()->json([
                'reply' => 'عذراً، لم أتمكن من معالجة طلبك. حاول مرة أخرى.',
            ]);

        } catch (\Exception $e) {
            Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['reply' => 'حدث خطأ غير متوقع، يرجى المحاولة لاحقاً.'], 500);
        }
    }

    /**
     * Build a structured snapshot of the system data from the database.
     * This is injected into the AI system prompt so it can answer any question.
     */
    private function buildSystemContext($currentUser): string
    {
        // --- Global stats ---
        $totalTasks   = KanbanTask::count();
        $totalUsers   = User::count();
        $totalColumns = KanbanColumn::count();

        $highCount   = KanbanTask::where('priority', 'high')->count();
        $mediumCount = KanbanTask::where('priority', 'medium')->count();
        $lowCount    = KanbanTask::where('priority', 'low')->count();

        $myTasksCount = KanbanTask::where('user_id', $currentUser->id)->count();

        // --- Columns with task counts ---
        $columns = KanbanColumn::withCount('tasks')->orderBy('position')->get();
        $columnsInfo = '';
        foreach ($columns as $col) {
            $columnsInfo .= "  - \"{$col->name}\" (اللون: {$col->color}): {$col->tasks_count} مهمة\n";
        }
        if (empty(trim($columnsInfo))) {
            $columnsInfo = "  لا توجد أعمدة بعد.\n";
        }

        // --- Users with their task counts ---
        $users = User::withCount('tasks')->orderBy('name')->get();
        $usersInfo = '';
        foreach ($users as $u) {
            $isCurrentUser = ($u->id === $currentUser->id) ? ' (المستخدم الحالي)' : '';
            $usersInfo .= "  - {$u->name} (ID: {$u->id}){$isCurrentUser}: {$u->tasks_count} مهمة\n";
        }
        if (empty(trim($usersInfo))) {
            $usersInfo = "  لا يوجد مستخدمون.\n";
        }

        // --- Recent high priority tasks (up to 5) ---
        $highTasks = KanbanTask::where('priority', 'high')
            ->with(['user', 'column'])
            ->latest()
            ->limit(5)
            ->get();
        $highTasksInfo = '';
        foreach ($highTasks as $t) {
            $assignee = $t->user ? $t->user->name : 'غير مُسند';
            $col      = $t->column ? $t->column->name : 'غير محدد';
            $highTasksInfo .= "  - \"{$t->title}\" | العمود: {$col} | المسؤول: {$assignee}\n";
        }
        if (empty(trim($highTasksInfo))) {
            $highTasksInfo = "  لا توجد مهام عاجلة.\n";
        }

        // --- Current user's tasks (up to 10) ---
        $myTasks = KanbanTask::where('user_id', $currentUser->id)
            ->with('column')
            ->latest()
            ->limit(10)
            ->get();
        $myTasksInfo = '';
        foreach ($myTasks as $t) {
            $col = $t->column ? $t->column->name : 'غير محدد';
            $myTasksInfo .= "  - \"{$t->title}\" | الأولوية: {$t->priority} | العمود: {$col}\n";
        }
        if (empty(trim($myTasksInfo))) {
            $myTasksInfo = "  لا توجد مهام مسندة لك.\n";
        }

        return <<<CONTEXT
أنت مساعد ذكاء اصطناعي لتطبيق EPG Kanban الخاص بمنظمة EPG.ma.
مهمتك الإجابة على أسئلة المستخدمين بشكل ذكي وطبيعي بناءً على البيانات الحقيقية للنظام المُقدَّمة أدناه.
يمكنك الإجابة بالعربية أو الفرنسية أو الإنجليزية حسب لغة السؤال.
أجب بشكل موجز ومفيد. لا تخترع معلومات غير موجودة في البيانات.

=== بيانات النظام الحالية ===

المستخدم الحالي: {$currentUser->name} (ID: {$currentUser->id}, Email: {$currentUser->email})

الإحصائيات العامة:
  - إجمالي المهام: {$totalTasks}
  - إجمالي المستخدمين: {$totalUsers}
  - إجمالي الأعمدة: {$totalColumns}
  - مهام عالية الأولوية (High): {$highCount}
  - مهام متوسطة الأولوية (Medium): {$mediumCount}
  - مهام منخفضة الأولوية (Low): {$lowCount}
  - مهامي أنا (المستخدم الحالي): {$myTasksCount}

الأعمدة (Columns):
{$columnsInfo}
المستخدمون وعدد مهامهم:
{$usersInfo}
المهام العاجلة (High Priority) الأخيرة:
{$highTasksInfo}
مهام المستخدم الحالي:
{$myTasksInfo}
=== نهاية البيانات ===
CONTEXT;
    }

    /**
     * Call Groq API with the full system context injected.
     */
    private function callGroqApi(string $userMessage, $user): ?string
    {
        try {
            $apiKey = config('services.groq.key', '');
            if (empty($apiKey)) {
                Log::warning('Groq API key is missing.');
                return 'مفتاح Groq API غير مضبوط. تواصل مع المسؤول.';
            }

            $systemPrompt = $this->buildSystemContext($user);

            $response = Http::withoutVerifying()
                ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => config('services.groq.model', 'llama3-8b-8192'),
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $userMessage],
                ],
                'max_tokens'  => 600,
                'temperature' => 0.4, // Lower = more factual, less hallucination
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('Groq API failed: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Groq Exception: ' . $e->getMessage());
            return null;
        }
    }
}
