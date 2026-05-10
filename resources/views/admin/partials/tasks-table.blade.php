<div class="table-card" id="tasks">
    <div class="table-card-header">
        <span class="table-card-title">Tâches récentes</span>
        @include('admin.components.badge', ['type' => 'gray', 'text' => $totalTasks . ' au total'])
    </div>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Assigné à</th>
                <th>Colonne</th>
                <th>Priorité</th>
                <th>Créée le</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTasks as $task)
                <tr>
                    <td style="color:var(--text);font-weight:600;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ $task->title }}
                    </td>
                    <td>
                        @if($task->user)
                            <div class="user-cell">
                                @include('admin.components.user-avatar', [
                                    'user' => $task->user,
                                    'size' => 24,
                                    'fontSize' => '0.62rem'
                                ])
                                {{ $task->user->name }}
                            </div>
                        @else
                            <span style="color:var(--text3)">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge" style="background:{{ $task->column->color }}22;color:{{ $task->column->color }}">
                            {{ $task->column->name }}
                        </span>
                    </td>
                    <td>
                        <span class="priority-dot {{ $task->priority }}">
                            @if($task->priority === 'high') Haute
                            @elseif($task->priority === 'medium') Moyenne
                            @else Basse
                            @endif
                        </span>
                    </td>
                    <td style="color:var(--text3);font-size:0.75rem">
                        {{ $task->created_at->diffForHumans() }}
                    </td>
                    <td>
                        <form action="{{ route('kanban.tasks.destroy', $task) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:0.28rem 0.6rem;font-size:0.72rem" onclick="return confirm('Supprimer cette tâche ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">Aucune tâche</td>
                </tr>
            @endforelse
        </tbody>
    </table>
     <div style="padding: 1rem">
        {{ $recentTasks->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
