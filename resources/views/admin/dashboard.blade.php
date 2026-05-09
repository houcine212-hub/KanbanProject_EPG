<!DOCTYPE html>
<html lang="fr" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord — EPG Kanban</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- ✅ PWA --}}
    @include('partials.pwa-head')

    @include('admin.partials.styles')
</head>
<body>

@include('admin.partials.sidebar')

<div class="main">
    @include('admin.partials.topbar')

    <div class="content">
        @include('admin.partials.stats')

        <div class="grid-2">
            @include('admin.partials.users-table')
            @include('admin.partials.columns-grid')
        </div>

        @include('admin.partials.tasks-table')
    </div>
</div>

@include('admin.modals.add-column-modal')
@include('components.chat_styles')
@include('components.chat_widget')
@include('chatbot')

<script>
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

    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    document.querySelectorAll('.modal-overlay').forEach(o => {
        o.addEventListener('click', e => { if (e.target === o) o.classList.remove('active'); });
    });
</script>

</body>
</html>
