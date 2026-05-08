@php
    $pal2 = ['#0055b3','#059669','#d97706','#dc2626','#7c3aed','#0284c7','#ea580c'];
    $tc = $task->user ? $pal2[$task->user->id % count($pal2)] : '#8fa3bc';
    $ti = $task->user ? strtoupper(substr($task->user->name, 0, 1)) : '?';
@endphp
<div class="task-card"
     data-task-id="{{ $task->id }}"
     data-title="{{ $task->title }}"
     data-description="{{ $task->description }}"
     data-priority="{{ $task->priority }}">

    <div class="task-title">{{ $task->title }}</div>

    @if($task->description)
        <div class="task-desc">{{ Str::limit($task->description, 80) }}</div>
    @endif

    @if($isAdmin)
        <div class="task-owner-row">
            <div class="task-owner-avatar" @if(!($task->user && $task->user->avatar)) style="background:{{ $tc }}" @endif>
                @if($task->user && $task->user->avatar)
                    <img src="{{ asset('storage/' . $task->user->avatar) }}" alt="{{ $task->user->name }}">
                @else
                    {{ $ti }}
                @endif
            </div>
            <span class="task-owner-name">{{ $task->user?->name ?? 'Unknown' }}</span>
        </div>
    @endif

    <div class="task-footer">
        <span class="priority-badge priority-{{ $task->priority }}">{{ $task->priority }}</span>
        <div class="task-actions">
            @if($isAdmin)
                <button type="button" class="btn-task btn-task-edit"
                        onclick="openEditModal(this.closest('.task-card'))">Edit</button>
            @endif
            @if($isAdmin || $task->user_id === auth()->id())
                <form action="{{ route('kanban.tasks.destroy', $task) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-task btn-task-del">Delete</button>
                </form>
            @endif
        </div>
    </div>
</div>