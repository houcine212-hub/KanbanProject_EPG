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
                return response()->json(['reply' => 'Veuillez vous connecter d abord.']);
            }

            $userMessage = trim($request->input('message'));

            $pendingDelete = Session::get('pending_delete_priority');
            if ($pendingDelete) {
                if ($this->isConfirmation($userMessage)) {
                    Session::forget('pending_delete_priority');
                    return $this->executePriorityDelete($pendingDelete, $user);
                }
                if ($this->isCancellation($userMessage)) {
                    Session::forget('pending_delete_priority');
                    return response()->json(['reply' => 'Operation de suppression annulee.']);
                }
            }

            if ($this->hasCreateIntent($userMessage)) {
                return $this->handleCreateTask($userMessage, $user);
            }

            $detectedPriority = $this->detectDeleteIntent($userMessage);
            if ($detectedPriority) {
                $count = KanbanTask::where('priority', $detectedPriority)->count();
                if ($count === 0) {
                    return response()->json([
                        'reply' => "Aucune tache avec priorite {$this->priorityLabel($detectedPriority)} a supprimer."
                    ]);
                }
                Session::put('pending_delete_priority', $detectedPriority);
                return response()->json([
                    'reply' => "Vous etes sur le point de supprimer {$count} taches avec priorite {$this->priorityLabel($detectedPriority)}.\n\nCette action est irreversible!\n\nEcrivez CONFIRMER pour continuer ou ANNULER pour annuler."
                ]);
            }

            $aiReply = $this->callGroqApi($userMessage, $user);
            return response()->json([
                'reply' => $aiReply ?? 'Desole, je n ai pas pu traiter votre demande. Reessayez.'
            ]);

        } catch (\Exception $e) {
            Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['reply' => 'Une erreur inattendue s est produite. Reessayez plus tard.'], 500);
        }
    }

    private function hasCreateIntent(string $message): bool
    {
        return $this->containsAny(mb_strtolower($message), [
            'ajouter', 'ajoute', 'creer', 'cree', 'nouvelle tache',
            'create', 'add task', 'new task',
        ]);
    }

    private function handleCreateTask(string $userMessage, $user): JsonResponse
    {
        $parsed = $this->parseTaskFromMessage($userMessage);

        if (!$parsed || empty($parsed['title'])) {
            return response()->json([
                'reply' => "Je n ai pas compris les details de la tache. Veuillez ecrire sous cette forme:\n\n"
                    . "AJOUTER tache [titre] priorite [haute/moyenne/basse] assigner a [nom utilisateur] apres [X minutes/heures]"
            ]);
        }

        $title       = $parsed['title'];
        $description = $parsed['description'] ?? '';
        $priority    = in_array($parsed['priority'] ?? '', ['high', 'medium', 'low'])
                       ? $parsed['priority'] : 'medium';
        $schedule    = $parsed['schedule']    ?? null;
        $assigneeName = $parsed['assigned_to'] ?? null;

        $assigneeId   = $user->id;
        $assigneeLabel = $user->name;

        if ($assigneeName) {
            $found = User::whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($assigneeName) . '%'])->first();
            if ($found) {
                $assigneeId    = $found->id;
                $assigneeLabel = $found->name;
            } else {
                return response()->json([
                    'reply' => "Utilisateur \"{$assigneeName}\" non trouve.\n\nUtilisateurs disponibles:\n"
                        . User::orderBy('name')->get()->map(fn($u) => "- {$u->name}")->implode("\n")
                ]);
            }
        }

        $runAt = $this->parseSchedule($schedule);

        $job = CreateTaskJob::dispatch($title, $description, $priority, $assigneeId);

        if ($runAt && $runAt->isFuture()) {
            CreateTaskJob::dispatch($title, $description, $priority, $assigneeId)
                ->delay($runAt);

            $timeLabel = $runAt->format('H:i') . ' (' . $runAt->diffForHumans() . ')';

            return response()->json([
                'reply' => "Planifie avec succes!\n\n"
                    . "Tache: {$title}\n"
                    . "Priorite: {$this->priorityLabel($priority)}\n"
                    . "Assigne a: {$assigneeLabel}\n"
                    . "Heure de creation: {$timeLabel}"
            ]);
        }

        CreateTaskJob::dispatch($title, $description, $priority, $assigneeId);

        return response()->json([
            'reply' => "Tache creee!\n\n"
                . "Tache: {$title}\n"
                . "Priorite: {$this->priorityLabel($priority)}\n"
                . "Assigne a: {$assigneeLabel}"
        ]);
    }

    private function parseTaskFromMessage(string $userMessage): ?array
    {
        try {
            $apiKey = config('services.groq.key', '');
            if (empty($apiKey)) return null;

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
Extraire les details de la tache du message utilisateur et retourner UNIQUEMENT un objet JSON valide sans texte supplementaire ni markdown.

Format JSON:
{
  "title": "titre de la tache",
  "description": "description ou chaine vide",
  "priority": "high|medium|low",
  "schedule": "5 minutes|2 hours|1 day|14:30|null",
  "assigned_to": "nom exact ou null"
}

Regles:
- priority: defaut "medium" si non mentionnee
- schedule:
    "apres 5 minutes" ou "after 5 minutes" ou "dans 5 minutes" -> "5 minutes"
    "apres 3 heures" ou "after 3 hours" -> "3 hours"
    "a 14h30" ou "at 2:30pm" ou "a 14:30" -> "14:30"
    aucun horaire mentionne -> null
- assigned_to:
    "assigner a Ahmed" ou "assign to Ahmed" ou "assigner a Ahmed" -> "Ahmed"
    aucun assignataire mentionne -> null
    Utilisateurs disponibles: {$usersList}

Retourner UNIQUEMENT le JSON, pas d explication, pas de fences markdown.
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

    private function parseSchedule(?string $schedule): ?Carbon
    {
        if (!$schedule || in_array(strtolower(trim($schedule)), ['null', ''])) return null;

        $s = strtolower(trim($schedule));

        if (preg_match('/^(\d+)\s*(hour|hours|h|heure|heures)$/', $s, $m))
            return Carbon::now()->addHours((int)$m[1]);

        if (preg_match('/^(\d+)\s*(minute|minutes|min|mins|minute|minutes)$/', $s, $m))
            return Carbon::now()->addMinutes((int)$m[1]);

        if (preg_match('/^(\d+)\s*(day|days|jour|jours)$/', $s, $m))
            return Carbon::now()->addDays((int)$m[1]);

        if (preg_match('/^(\d{1,2}):(\d{2})$/', $s, $m)) {
            $target = Carbon::today()->setHour((int)$m[1])->setMinute((int)$m[2])->setSecond(0);
            if ($target->isPast()) $target->addDay();
            return $target;
        }

        return null;
    }

    private function detectDeleteIntent(string $message): ?string
    {
        $msg = mb_strtolower($message);
        $hasDelete = $this->containsAny($msg, ['supprimer', 'supprime', 'delete', 'remove', 'effacer']);
        if (!$hasDelete) return null;

        if ($this->containsAny($msg, ['high', 'haute', 'urgent', 'elevee']))  return 'high';
        if ($this->containsAny($msg, ['medium', 'moyenne', 'moyen']))          return 'medium';
        if ($this->containsAny($msg, ['low', 'basse', 'faible']))     return 'low';

        return null;
    }

    private function executePriorityDelete(string $priority, $user): JsonResponse
    {
        $deleted = KanbanTask::where('priority', $priority)->delete();
        Log::info("Utilisateur [{$user->name}] a supprime {$deleted} taches avec priorite '{$priority}'");
        return response()->json([
            'reply' => "{$deleted} taches avec priorite {$this->priorityLabel($priority)} supprimees avec succes."
        ]);
    }

    private function isConfirmation(string $msg): bool
    {
        return $this->containsAny(mb_strtolower($msg), ['confirmer', 'oui', 'ok', 'yes', 'confirm']);
    }

    private function isCancellation(string $msg): bool
    {
        return $this->containsAny(mb_strtolower($msg), ['annuler', 'non', 'cancel', 'no', 'retour']);
    }

    private function priorityLabel(string $priority): string
    {
        return match($priority) {
            'high'   => 'Haute',
            'medium' => 'Moyenne',
            'low'    => 'Basse',
            default  => $priority,
        };
    }

    private function callGroqApi(string $userMessage, $user): ?string
    {
        try {
            $apiKey = config('services.groq.key', '');
            if (empty($apiKey)) return 'Cle API Groq non configuree.';

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
            $columnsInfo .= "  - \"{$col->name}\": {$col->tasks_count} taches\n";
        }
        if (empty(trim($columnsInfo))) $columnsInfo = "  Aucune colonne.\n";

        $users = User::withCount('tasks')->orderBy('name')->get();
        $usersInfo = '';
        foreach ($users as $u) {
            $isMe = ($u->id === $currentUser->id) ? ' (actuel)' : '';
            $usersInfo .= "  - {$u->name}{$isMe}: {$u->tasks_count} taches\n";
        }

        $tasksByPriorityInfo = '';
        foreach (['high' => 'Haute', 'medium' => 'Moyenne', 'low' => 'Basse'] as $p => $label) {
            $tasks = KanbanTask::where('priority', $p)->with(['user', 'column'])->get();
            $tasksByPriorityInfo .= "  [{$label}]:\n";
            if ($tasks->isEmpty()) {
                $tasksByPriorityInfo .= "    - Aucune tache\n";
            } else {
                foreach ($tasks as $t) {
                    $assignee = $t->user   ? $t->user->name   : 'Non assigne';
                    $col      = $t->column ? $t->column->name : 'Non defini';
                    $tasksByPriorityInfo .= "    - \"{$t->title}\" | {$col} | {$assignee}\n";
                }
            }
        }

        $myTasks = KanbanTask::where('user_id', $currentUser->id)->with('column')->latest()->limit(10)->get();
        $myTasksInfo = '';
        foreach ($myTasks as $t) {
            $col = $t->column ? $t->column->name : 'Non defini';
            $myTasksInfo .= "  - \"{$t->title}\" | {$t->priority} | {$col}\n";
        }
        if (empty(trim($myTasksInfo))) $myTasksInfo = "  Aucune tache.\n";

        return <<<CONTEXT
Vous etes un assistant IA pour l application EPG Kanban - organisation EPG.ma.
Repondez intelligemment et brievement en vous basant sur les donnees reelles ci-dessous.
Repondez dans la langue de la question (francais/anglais/arabe).
N inventez pas d informations. Les operations de creation et suppression sont independantes.

=== Donnees du systeme ===
Utilisateur actuel: {$currentUser->name} (ID: {$currentUser->id})
Statistiques: {$totalTasks} taches | {$totalUsers} utilisateurs | {$totalColumns} colonnes
Priorites: Haute={$highCount} | Moyenne={$mediumCount} | Basse={$lowCount} | Mes taches={$myTasksCount}

Colonnes:
{$columnsInfo}
Utilisateurs:
{$usersInfo}
Taches par priorite:
{$tasksByPriorityInfo}
Mes taches:
{$myTasksInfo}
=== Fin des donnees ===
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
