<div class="modal-overlay" id="editColumnModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Modifier la colonne</h3>
            <button class="modal-close" onclick="closeModal('editColumnModal')">&#215;</button>
        </div>
        <form id="editColumnForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Nom de la colonne</label>
                <input type="text" name="name" id="editColumnName" required>
            </div>
            <div class="form-group">
                <label>Couleur</label>
                <input type="color" name="color" id="editColumnColor">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editColumnModal')">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
