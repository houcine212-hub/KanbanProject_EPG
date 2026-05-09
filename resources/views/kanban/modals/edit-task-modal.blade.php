<div class="modal-overlay" id="editTaskModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Modifier la tâche</h3>
            <button class="modal-close" onclick="closeModal('editTaskModal')">&#215;</button>
        </div>
        <form id="editTaskForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Titre de la tâche</label>
                <input type="text" name="title" id="editTitle" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="editDescription"></textarea>
            </div>
            <div class="form-group">
                <label>Priorité</label>
                <select name="priority" id="editPriority">
                    <option value="low"> Basse</option>
                    <option value="medium"> Moyenne</option>
                    <option value="high"> Haute</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editTaskModal')">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
