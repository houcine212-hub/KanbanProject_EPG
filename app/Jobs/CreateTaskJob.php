<?php

namespace App\Jobs;

use App\Models\KanbanTask;
use App\Models\KanbanColumn;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string  $title,
        private readonly string  $description,
        private readonly string  $priority,
        private readonly int     $userId,
        private readonly ?int    $columnId = null,
    ) {}

    public function handle(): void
    {
        try {
            $columnId = $this->columnId
                ?? KanbanColumn::orderBy('position')->value('id');

            if (!$columnId) {
                Log::error('CreateTaskJob: Aucune colonne trouvee pour assigner la tache.');
                return;
            }

            $maxPosition = KanbanTask::where('kanban_column_id', $columnId)->max('position') ?? 0;

            KanbanTask::create([
                'kanban_column_id' => $columnId,
                'user_id'          => $this->userId,
                'title'            => $this->title,
                'description'      => $this->description,
                'priority'         => $this->priority,
                'position'         => $maxPosition + 1,
            ]);

            Log::info("CreateTaskJob: Tache \"{$this->title}\" creee avec succes pour l utilisateur {$this->userId}");

        } catch (\Exception $e) {
            Log::error('CreateTaskJob a echoue: ' . $e->getMessage());
            throw $e;
        }
    }
}
