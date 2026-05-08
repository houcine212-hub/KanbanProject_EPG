<!DOCTYPE html>
<html lang="ar" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EPG Kanban Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    @include('kanban.partials.styles')
</head>
<body>

@if($isAdmin)
    @include('kanban.partials.sidebar')
@endif

<div class="main">
    @include('kanban.partials.topbar')
    @include('kanban.partials.board')
</div>

@include('kanban.modals.task-modal')
@include('kanban.modals.edit-column-modal')

@if($isAdmin)
    @include('kanban.modals.column-modal')
    @include('kanban.modals.edit-task-modal')
@endif

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const isAdmin   = {{ $isAdmin ? 'true' : 'false' }};

    /* ── Collapsible Users List ── */
    function toggleUsers() {
        const btn  = document.getElementById('usersToggleBtn');
        const list = document.getElementById('usersList');
        btn.classList.toggle('open');
        list.classList.toggle('open');
    }

    /* ── Modals ── */
    function openTaskModal(columnId) {
        document.getElementById('taskColumnId').value = columnId;
        document.getElementById('taskModal').classList.add('active');
    }

    function openColumnModal() {
        document.getElementById('columnModal').classList.add('active');
    }

    function openEditModal(card) {
        document.getElementById('editTitle').value       = card.dataset.title;
        document.getElementById('editDescription').value = card.dataset.description || '';
        document.getElementById('editPriority').value    = card.dataset.priority;
        document.getElementById('editTaskForm').action   = `/kanban/tasks/${card.dataset.taskId}`;
        document.getElementById('editTaskModal').classList.add('active');
    }

    function openEditColumnModal(btn) {
        const col = btn.closest('.column');
        document.getElementById('editColumnName').value  = col.dataset.columnName;
        document.getElementById('editColumnColor').value = col.dataset.columnColor;
        document.getElementById('editColumnForm').action = `/kanban/columns/${col.dataset.columnId}`;
        document.getElementById('editColumnModal').classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(m => m.classList.remove('active'));
        }
    });

    /* ── Sortable Columns ── */
    new Sortable(document.getElementById('board'), {
        group: 'columns',
        animation: 150,
        handle: '.column-header',
        draggable: '.column',
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        onEnd: function () {
            const payload = [];
            document.querySelectorAll('.column[data-column-id]').forEach((col, index) => {
                payload.push({ id: col.dataset.columnId, position: index });
            });

            fetch('{{ route("kanban.columns.reorder") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ columns: payload }),
            });
        }
    });

    /* ── Sortable Tasks ── */
    document.querySelectorAll('.task-list').forEach(list => {
        new Sortable(list, {
            group: 'tasks',
            animation: 150,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function () {
                const payload = [];
                document.querySelectorAll('.task-list').forEach(col => {
                    col.querySelectorAll('.task-card').forEach((card, index) => {
                        payload.push({
                            id: card.dataset.taskId,
                            column_id: col.dataset.column,
                            position: index,
                        });
                    });
                });

                fetch('{{ route("kanban.tasks.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ tasks: payload }),
                });

                document.querySelectorAll('.column').forEach(col => {
                    col.querySelector('.column-count').textContent =
                        col.querySelector('.task-list').querySelectorAll('.task-card').length;
                });
            }
        });
    });

    /* ── Dark mode toggle ── */
    (function() {
        const saved = localStorage.getItem('epg-theme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
    })();

    document.getElementById('themeToggle').addEventListener('click', () => {
        const curr = document.documentElement.getAttribute('data-theme');
        const next = curr === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('epg-theme', next);
    });
</script>

</body>
</html>