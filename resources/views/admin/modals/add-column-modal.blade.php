<div class="modal-overlay" id="addColumnModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Ajouter une colonne</span>
            <button class="modal-close" onclick="closeModal('addColumnModal')">&#215;</button>
        </div>
        <form action="{{ route('kanban.columns.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom de la colonne</label>
                    <input type="text" name="name" class="form-control" placeholder="ex. En révision" required>
                </div>
                <div class="form-group">
                    <label>Couleur</label>
                    <input type="color" name="color" class="form-control" value="#0055b3" style="height:44px;padding:0.3rem 0.5rem;cursor:pointer">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addColumnModal')">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
</div>
