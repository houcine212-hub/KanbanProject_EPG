@php
    $palette = ['#0055b3','#059669','#d97706','#dc2626','#7c3aed','#0284c7','#ea580c'];
    $uc = $palette[$u->id % count($palette)];
    $ui = strtoupper(substr($u->name, 0, 1));
@endphp
<a href="{{ route('kanban.index', ['user_id' => $u->id]) }}"
   class="user-nav-item {{ $selectedUserId == $u->id ? 'active' : '' }}">
    <div class="user-avatar" @if(!$u->avatar) style="background:{{ $uc }}" @endif>
        @if($u->avatar)
            <img src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->name }}">
        @else
            {{ $ui }}
        @endif
    </div>
    <span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
        {{ $u->name }}
    </span>
    <span class="nav-count">{{ $u->tasks_count }}</span>
</a>