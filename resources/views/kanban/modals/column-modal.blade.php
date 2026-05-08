<div class="modal-overlay" id="columnModal">
    <div class="modal">
        <div class="modal-header">
            <h3>New Column</h3>
            <button class="modal-close" onclick="closeModal('columnModal')">&#215;</button>
        </div>
        <form action="{{ route('kanban.columns.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Column Name</label>
                <input type="text" name="name" required placeholder="e.g. In Review">
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="color" name="color" value="#0055b3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('columnModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Column</button>
            </div>
        </form>
    </div>
</div>