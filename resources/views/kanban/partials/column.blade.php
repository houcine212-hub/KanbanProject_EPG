<div class="column" data-column-id="{{ $column->id }}" data-column-name="{{ $column->name }}" data-column-color="{{ $column->color }}">
    <div class="column-header">
        <div class="column-title">
            <div class="column-dot" style="background: {{ $column->color }}"></div>
            {{ $column->name }}
            <span class="column-count">{{ $column->tasks->count() }}</span>
        </div>
        <div style="display:flex;gap:0.2rem;align-items:center;">
            <button type="button" class="btn-icon edit" title="Modifier la colonne" onclick="openEditColumnModal(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            @if($isAdmin)
                <form action="{{ route('kanban.columns.destroy', $column) }}" method="POST"
                      onsubmit="return confirm('Supprimer la colonne «{{ $column->name }}» ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon" title="Supprimer la colonne">&#215;</button>
                </form>
            @endif
        </div>
    </div>

    <div class="task-list" id="task-list-{{ $column->id }}" data-column="{{ $column->id }}">
        @forelse($column->tasks as $task)
            @include('kanban.partials.task-card', ['task' => $task])
        @empty
            @include('kanban.partials.empty-state')
        @endforelse
    </div>

    {{-- Add Task button for all users including admin --}}
    <button class="add-task-btn" onclick="openTaskModal({{ $column->id }})">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Ajouter une tâche
    </button>
</div>
