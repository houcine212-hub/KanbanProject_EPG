<div class="modal-overlay" id="editTaskModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Task</h3>
            <button class="modal-close" onclick="closeModal('editTaskModal')">&#215;</button>
        </div>
        <form id="editTaskForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" id="editTitle" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="editDescription"></textarea>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority" id="editPriority">
                    <option value="low">🟢 Low</option>
                    <option value="medium">🟡 Medium</option>
                    <option value="high">🔴 High</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editTaskModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>