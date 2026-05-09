<div class="modal-overlay" id="taskModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Nouvelle tâche</h3>
            <button class="modal-close" onclick="closeModal('taskModal')">&#215;</button>
        </div>
        <div style="display:flex;align-items:center;gap:0.6rem;padding:0.75rem 0 0.75rem;margin-bottom:0.5rem;border-bottom:1px solid var(--border);">
            <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#0055b3,#1a70d4);display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;color:white;box-shadow:0 0 0 2px var(--surface),0 0 0 3.5px var(--border2);">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" alt="">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.78rem;font-weight:700;color:var(--text);line-height:1.2;">{{ auth()->user()->name }}</div>
                <div style="font-size:0.68rem;color:var(--text3);">{{ auth()->user()->isAdmin() ? 'Administrateur' : 'Membre' }} · Ajout d'une nouvelle tâche</div>
            </div>
            <span style="font-size:0.63rem;font-weight:700;padding:0.16rem 0.5rem;border-radius:999px;background:var(--accent-bg);color:var(--accent2);border:1px solid var(--accent-bg2);text-transform:uppercase;letter-spacing:0.05em;">Nouveau</span>
        </div>
        <form action="{{ route('kanban.tasks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kanban_column_id" id="taskColumnId">
            <div class="form-group">
                <label>Titre de la tâche</label>
                <input type="text" name="title" required placeholder="Que faut-il faire ?">
            </div>
            <div class="form-group">
                <label>Description <span style="font-weight:400;color:var(--text3)">(optionnel)</span></label>
                <textarea name="description" placeholder="Ajouter plus de détails..."></textarea>
            </div>
            <div class="form-group">
                <label>Priorité</label>
                <select name="priority">
                    <option value="low">Basse</option>
                    <option value="medium" selected>Moyenne</option>
                    <option value="high">Haute</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('taskModal')">Annuler</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>
