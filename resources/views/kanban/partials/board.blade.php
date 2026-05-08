<div class="board-wrap">
    <div class="board" id="board">
        @foreach($columns as $column)
            @include('kanban.partials.column', ['column' => $column])
        @endforeach

        @if($isAdmin)
            <div class="add-column-card" onclick="openColumnModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                New Column
            </div>
        @endif
    </div>
</div>