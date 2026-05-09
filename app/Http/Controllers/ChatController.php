<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Jobs\CreateTaskJob;
use App\Models\KanbanTask;
use App\Models\KanbanColumn;
use App\Models\User;

class ChatController extends Controller
{
    public function ask(Request $request): JsonResponse
    {
        try {
            $request->validate(['message' => 'required|string|max:2000']);

            $user = auth()->user();
            if (!$user) {
                return response()->json(['reply' => 'يرجى تسجيل الدخول أولاً.']);
            }

            $userMessage = trim($request->input('message'));

            // ── 1. Pending delete confirmation ──────────────────────────
            $pendingDelete = Session::get('pending_delete_priority');
            if ($pendingDelete) {
                if ($this->isConfirmation($userMessage)) {
                    Session::forget('pending_delete_priority');
                    return $this->executePriorityDelete($pendingDelete, $user);
                }
                if ($this->isCancellation($userMessage)) {
                    Session::forget('pending_delete_priority');
                    return response()->json(['reply' => '❌ تم إلغاء عملية الحذف.']);
                }
            }

            // ── 2. Detect create-task intent ────────────────────────────
            if ($this->hasCreateIntent($userMessage)) {
                return $this->handleCreateTask($userMessage, $user);
            }

            // ── 3. Detect delete-by-priority intent ─────────────────────
            $detectedPriority = $this->detectDeleteIntent($userMessage);
            if ($detectedPriority) {
                $count = KanbanTask::where('priority', $detectedPriority)->count();
                if ($count === 0) {
                    return response()->json([
                        'reply' => "ℹ️ لا توجد مهام بأولوية **{$this->priorityLabel($detectedPriority)}** لحذفها."
                    ]);
                }
                Session::put('pending_delete_priority', $detectedPriority);
                return response()->json([
                    'reply' => "⚠️ أنت على وشك حذف **{$count} مهمة** بأولوية **{$this->priorityLabel($detectedPriority)}**.\n\nهذا الإجراء لا يمكن التراجع عنه!\n\nاكتب **تأكيد** للمتابعة أو **إلغاء** للتراجع."
                ]);
            }

            // ── 4. Everything else → Groq AI ────────────────────────────
            $aiReply = $this->callGroqApi($userMessage, $user);
            return response()->json([
                'reply' => $aiReply ?? 'عذراً، لم أتمكن من معالجة طلبك. حاول مرة أخرى.'
            ]);

        } catch (\Exception $e) {
            Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['reply' => 'حدث خطأ غير متوقع، يرجى المحاولة لاحقاً.'], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  CREATE TASK
    // ══════════════════════════════════════════════════════════════

    private function hasCreateIntent(string $message): bool
    {
        return $this->containsAny(mb_strtolower($message), [
            'زيد', 'أضف', 'اضف', 'إضافة', 'أنشئ', 'انشئ',
            'create', 'add task', 'ajouter', 'creer', 'nouvelle tache',
        ]);
    }

    private function handleCreateTask(string $userMessage, $user): JsonResponse
    {
        $parsed = $this->parseTaskFromMessage($userMessage);

        if (!$parsed || empty($parsed['title'])) {
            return response()->json([
                'reply' => "لم أفهم تفاصيل المهمة. يرجى الكتابة بهذا الشكل:\n\n"
                    . "**زيد task** [العنوان] priority [high/medium/low] سند لـ [اسم المستخدم] بعد [X دقائق/ساعات]"
            ]);
        }

        $title       = $parsed['title'];
        $description = $parsed['description'] ?? '';
        $priority    = in_array($parsed['priority'] ?? '', ['high', 'medium', 'low'])
                       ? $parsed['priority'] : 'medium';
        $schedule    = $parsed['schedule']    ?? null;
        $assigneeName = $parsed['assigned_to'] ?? null;

        // ── Resolve assignee ──────────────────────────────────────
        $assigneeId   = $user->id;   // default: current user
        $assigneeLabel = $user->name;

        if ($assigneeName) {
            $found = User::whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($assigneeName) . '%'])->first();
            if ($found) {
                $assigneeId    = $found->id;
                $assigneeLabel = $found->name;
            } else {
                return response()->json([
                    'reply' => "⚠️ لم أجد مستخدماً باسم **{$assigneeName}**.\n\nالمستخدمون المتاحون:\n"
                        . User::orderBy('name')->get()->map(fn($u) => "• {$u->name}")->implode("\n")
                ]);
            }
        }

        // ── Parse schedule ────────────────────────────────────────
        $runAt = $this->parseSchedule($schedule);

        // ── Dispatch Job ──────────────────────────────────────────
        $job = CreateTaskJob::dispatch($title, $description, $priority, $assigneeId);

        if ($runAt && $runAt->isFuture()) {
            CreateTaskJob::dispatch($title, $description, $priority, $assigneeId)
                ->delay($runAt);

            $timeLabel = $runAt->format('H:i') . ' (' . $runAt->diffForHumans() . ')';

            return response()->json([
                'reply' => "✅ تمت الجدولة بنجاح!\n\n"
                    . "📌 **{$title}**\n"
                    . "🎯 الأولوية: {$this->priorityLabel($priority)}\n"
                    . "👤 مسند إلى: **{$assigneeLabel}**\n"
                    . "⏰ وقت الإنشاء: {$timeLabel}"
            ]);
        }

        // Immediate
        CreateTaskJob::dispatch($title, $description, $priority, $assigneeId);

        return response()->json([
            'reply' => "✅ تم إنشاء المهمة!\n\n"
                . "📌 **{$title}**\n"
                . "🎯 الأولوية: {$this->priorityLabel($priority)}\n"
                . "👤 مسند إلى: **{$assigneeLabel}**"
        ]);
    }

    /**
     * Call Groq to extract structured task data as JSON.
     */
    private function parseTaskFromMessage(string $userMessage): ?array
    {
        try {
            $apiKey = config('services.groq.key', '');
            if (empty($apiKey)) return null;

            // Build users list so AI can match names
            $usersList = User::orderBy('name')->pluck('name')->implode(', ');

            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])->timeout(20)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model', 'llama-3.3-70b-versatile'),
                    'messages' => [
                        [
                            'role'    => 'system',
                            'content' => <<<PROMPT
Extract task details from the user message and return ONLY a valid JSON object with no extra text or markdown.

JSON format:
{
  "title": "task title",
  "description": "task description or empty string",
  "priority": "high|medium|low",
  "schedule": "5 minutes|2 hours|1 day|14:30|null",
  "assigned_to": "exact username or null"
}

Rules:
- priority: default "medium" if not mentioned
- schedule:
    "بعد 5 دقائق" or "after 5 minutes" or "dans 5 minutes" → "5 minutes"
    "بعد 3 ساعات" or "after 3 hours" → "3 hours"
    "الساعة 14:30" or "at 2:30pm" or "à 14h30" → "14:30"
    no time mentioned → null
- assigned_to:
    "سند لـ Ahmed" or "assign to Ahmed" or "assigner à Ahmed" → "Ahmed"
    no assignee mentioned → null
    Available users: {$usersList}

Return ONLY the JSON, no explanation, no markdown fences.
PROMPT
                        ],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'max_tokens'  => 200,
                    'temperature' => 0.1,
                ]);

            if (!$response->successful()) return null;

            $content = $response->json('choices.0.message.content');
            $content = preg_replace('/```(?:json)?|```/', '', $content);
            $data    = json_decode(trim($content), true);

            return is_array($data) ? $data : null;

        } catch (\Exception $e) {
            Log::error('parseTaskFromMessage error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Parse schedule string into Carbon datetime.
     */
    private function parseSchedule(?string $schedule): ?Carbon
    {
        if (!$schedule || in_array(strtolower(trim($schedule)), ['null', ''])) return null;

        $s = strtolower(trim($schedule));

        if (preg_match('/^(\d+)\s*(hour|hours|h)$/', $s, $m))
            return Carbon::now()->addHours((int)$m[1]);

        if (preg_match('/^(\d+)\s*(minute|minutes|min|mins)$/', $s, $m))
            return Carbon::now()->addMinutes((int)$m[1]);

        if (preg_match('/^(\d+)\s*(day|days)$/', $s, $m))
            return Carbon::now()->addDays((int)$m[1]);

        if (preg_match('/^(\d{1,2}):(\d{2})$/', $s, $m)) {
            $target = Carbon::today()->setHour((int)$m[1])->setMinute((int)$m[2])->setSecond(0);
            if ($target->isPast()) $target->addDay();
            return $target;
        }

        return null;
    }

    // ══════════════════════════════════════════════════════════════
    //  DELETE HELPERS
    // ══════════════════════════════════════════════════════════════

    private function detectDeleteIntent(string $message): ?string
    {
        $msg = mb_strtolower($message);
        $hasDelete = $this->containsAny($msg, ['حذف', 'احذف', 'امسح', 'مسح', 'delete', 'remove', 'supprimer']);
        if (!$hasDelete) return null;

        if ($this->containsAny($msg, ['high', 'عالية', 'عاجلة', 'urgent']))  return 'high';
        if ($this->containsAny($msg, ['medium', 'متوسطة', 'moyen']))          return 'medium';
        if ($this->containsAny($msg, ['low', 'منخفضة', 'bas', 'faible']))     return 'low';

        return null;
    }

    private function executePriorityDelete(string $priority, $user): JsonResponse
    {
        $deleted = KanbanTask::where('priority', $priority)->delete();
        Log::info("User [{$user->name}] deleted {$deleted} tasks with priority '{$priority}'");
        return response()->json([
            'reply' => "✅ تم حذف **{$deleted} مهمة** بأولوية **{$this->priorityLabel($priority)}** بنجاح."
        ]);
    }

    private function isConfirmation(string $msg): bool
    {
        return $this->containsAny(mb_strtolower($msg), ['تأكيد', 'نعم', 'ok', 'oui', 'yes', 'confirm']);
    }

    private function isCancellation(string $msg): bool
    {
        return $this->containsAny(mb_strtolower($msg), ['إلغاء', 'لا', 'cancel', 'non', 'no', 'تراجع']);
    }

    private function priorityLabel(string $priority): string
    {
        return match($priority) {
            'high'   => 'عالية 🔴',
            'medium' => 'متوسطة 🟡',
            'low'    => 'منخفضة 🟢',
            default  => $priority,
        };
    }

    // ══════════════════════════════════════════════════════════════
    //  GROQ AI (general questions)
    // ══════════════════════════════════════════════════════════════

    private function callGroqApi(string $userMessage, $user): ?string
    {
        try {
            $apiKey = config('services.groq.key', '');
            if (empty($apiKey)) return 'مفتاح Groq API غير مضبوط.';

            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model', 'llama-3.3-70b-versatile'),
                    'messages' => [
                        ['role' => 'system', 'content' => $this->buildSystemContext($user)],
                        ['role' => 'user',   'content' => $userMessage],
                    ],
                    'max_tokens'  => 600,
                    'temperature' => 0.4,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('Groq API failed: ' . $response->status() . ' | ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Groq Exception: ' . $e->getMessage());
            return null;
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  SYSTEM CONTEXT
    // ══════════════════════════════════════════════════════════════

    private function buildSystemContext($currentUser): string
    {
        $totalTasks   = KanbanTask::count();
        $totalUsers   = User::count();
        $totalColumns = KanbanColumn::count();
        $highCount    = KanbanTask::where('priority', 'high')->count();
        $mediumCount  = KanbanTask::where('priority', 'medium')->count();
        $lowCount     = KanbanTask::where('priority', 'low')->count();
        $myTasksCount = KanbanTask::where('user_id', $currentUser->id)->count();

        $columns = KanbanColumn::withCount('tasks')->orderBy('position')->get();
        $columnsInfo = '';
        foreach ($columns as $col) {
            $columnsInfo .= "  - \"{$col->name}\": {$col->tasks_count} مهمة\n";
        }
        if (empty(trim($columnsInfo))) $columnsInfo = "  لا توجد أعمدة.\n";

        $users = User::withCount('tasks')->orderBy('name')->get();
        $usersInfo = '';
        foreach ($users as $u) {
            $isMe = ($u->id === $currentUser->id) ? ' (الحالي)' : '';
            $usersInfo .= "  - {$u->name}{$isMe}: {$u->tasks_count} مهمة\n";
        }

        $tasksByPriorityInfo = '';
        foreach (['high' => 'عالية 🔴', 'medium' => 'متوسطة 🟡', 'low' => 'منخفضة 🟢'] as $p => $label) {
            $tasks = KanbanTask::where('priority', $p)->with(['user', 'column'])->get();
            $tasksByPriorityInfo .= "  [{$label}]:\n";
            if ($tasks->isEmpty()) {
                $tasksByPriorityInfo .= "    • لا توجد مهام\n";
            } else {
                foreach ($tasks as $t) {
                    $assignee = $t->user   ? $t->user->name   : 'غير مُسند';
                    $col      = $t->column ? $t->column->name : 'غير محدد';
                    $tasksByPriorityInfo .= "    • \"{$t->title}\" | {$col} | {$assignee}\n";
                }
            }
        }

        $myTasks = KanbanTask::where('user_id', $currentUser->id)->with('column')->latest()->limit(10)->get();
        $myTasksInfo = '';
        foreach ($myTasks as $t) {
            $col = $t->column ? $t->column->name : 'غير محدد';
            $myTasksInfo .= "  - \"{$t->title}\" | {$t->priority} | {$col}\n";
        }
        if (empty(trim($myTasksInfo))) $myTasksInfo = "  لا توجد مهام.\n";

        return <<<CONTEXT
أنت مساعد ذكاء اصطناعي لتطبيق EPG Kanban — منظمة EPG.ma.
أجب بذكاء وإيجاز بناءً على البيانات الحقيقية أدناه.
أجب بلغة السؤال (عربية/فرنسية/إنجليزية).
لا تخترع معلومات. عمليات الإنشاء والحذف تتم بشكل مستقل.

=== بيانات النظام ===
المستخدم الحالي: {$currentUser->name} (ID: {$currentUser->id})
الإحصائيات: {$totalTasks} مهمة | {$totalUsers} مستخدم | {$totalColumns} عمود
الأولويات: عالية={$highCount} | متوسطة={$mediumCount} | منخفضة={$lowCount} | مهامي={$myTasksCount}

الأعمدة:
{$columnsInfo}
المستخدمون:
{$usersInfo}
المهام حسب الأولوية:
{$tasksByPriorityInfo}
مهامي:
{$myTasksInfo}
=== نهاية البيانات ===
CONTEXT;
    }

    private function containsAny(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($message, mb_strtolower($keyword))) return true;
        }
        return false;
    }
}
