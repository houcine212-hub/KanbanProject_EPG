<div class="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('kanban.index') }}" class="epg-logo">
            <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG">
            <div class="epg-logo-text">
                <span class="epg-logo-name">EPG <span>Kanban</span></span>
                <span class="epg-logo-sub">Gestion des tâches</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Principal</div>

        <a href="{{ route('kanban.index') }}" class="nav-item">
            Tableau Kanban
        </a>

        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            Tableau de bord
        </a>

        <div class="nav-section-label">Gestion</div>

        <a href="{{ route('admin.dashboard') }}#users" class="nav-item">
            Utilisateurs
            <span class="nav-badge">{{ $usersCount }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#tasks" class="nav-item">
            Tâches
            <span class="nav-badge">{{ $totalTasks }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#columns" class="nav-item">
            Colonnes
            <span class="nav-badge">{{ $columns->count() }}</span>
        </a>

        <div class="nav-section-label">Compte</div>

        <a href="{{ route('profile') }}" class="nav-item">
            Mon profil
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="profile-row">
            <div class="profile-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ auth()->user()->name }}</div>
                <div class="profile-role">Administrateur</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Se déconnecter</button>
        </form>
    </div>
</div>
