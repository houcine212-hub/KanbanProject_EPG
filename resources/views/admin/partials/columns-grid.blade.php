<div class="table-card" id="columns">
    <div class="table-card-header">
        <span class="table-card-title">Colonnes du tableau</span>
        <button class="topbar-pill-btn" style="font-size:0.72rem;padding:0.25rem 0.7rem" onclick="openModal('addColumnModal')">
            <svg width="10" height="10" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 1v10M1 6h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Ajouter
        </button>
    </div>
    <div class="columns-grid">
        @foreach($columns as $col)
            <div class="column-chip">
                <span class="column-color-dot" style="background: {{ $col->color }}"></span>
                <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    {{ $col->name }}
                </span>
                <span class="column-chip-count">{{ $col->tasks->count() }}</span>
                <form action="{{ route('kanban.columns.destroy', $col) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="del-col-btn" onclick="return confirm('Supprimer cette colonne ?')">×</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
