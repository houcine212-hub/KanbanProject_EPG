<div class="modal-overlay" id="editColumnModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Column</h3>
            <button class="modal-close" onclick="closeModal('editColumnModal')">&#215;</button>
        </div>
        <form id="editColumnForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Column Name</label>
                <input type="text" name="name" id="editColumnName" required>
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="color" name="color" id="editColumnColor">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editColumnModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>