<div class="modal-overlay" id="columnModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Nouvelle colonne</h3>
            <button class="modal-close" onclick="closeModal('columnModal')">&#215;</button>
        </div>
        <form action="{{ route('kanban.columns.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nom de la colonne</label>
                <input type="text" name="name" required placeholder="ex. En révision">
            </div>
            <div class="form-group">
                <label>Couleur</label>
                <input type="color" name="color" value="#0055b3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('columnModal')">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
</div>
