<aside class="sidebar">
    {{-- EPG Logo --}}
    <div class="sidebar-logo">
        <a href="{{ route('kanban.index') }}" class="epg-logo">
            <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG" style="height:34px;width:34px;object-fit:cover;border-radius:50%;border:2px solid var(--border);flex-shrink:0;">
            <div class="epg-logo-text">
                <span class="epg-logo-name">EPG <span>Kanban</span></span>
                <span class="epg-logo-sub">Gestion des tâches</span>
            </div>
        </a>
    </div>

    <div class="sidebar-nav">
        {{-- WORKSPACE section --}}
        <div class="nav-section-label">Espace de travail</div>

        <a href="{{ route('kanban.index') }}"
           class="nav-item {{ !$selectedUserId && request('view') !== 'mine' ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 16 16" fill="currentColor">
                <rect x="1" y="1" width="6" height="6" rx="1"/>
                <rect x="9" y="1" width="6" height="6" rx="1"/>
                <rect x="1" y="9" width="6" height="6" rx="1"/>
                <rect x="9" y="9" width="6" height="6" rx="1"/>
            </svg>
            Toutes les tâches
            <span class="nav-count">{{ $users->sum('tasks_count') }}</span>
        </a>

        <a href="{{ route('kanban.index', ['view' => 'mine']) }}"
           class="nav-item {{ request('view') === 'mine' ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 16 16" fill="currentColor">
                <circle cx="8" cy="5" r="3"/>
                <path d="M2 14c0-3.31 2.69-6 6-6s6 2.69 6 6H2z"/>
            </svg>
            Mes tâches
            <span class="nav-count">{{ $adminTasksCount }}</span>
        </a>

        <div class="sidebar-divider"></div>
        <div class="nav-section-label">Utilisateurs</div>

        {{-- Collapsible Users Toggle --}}
        <button class="users-toggle {{ $selectedUserId ? 'open' : '' }}"
                id="usersToggleBtn"
                onclick="toggleUsers()">
            <svg class="nav-icon" style="width:16px;height:16px;flex-shrink:0;opacity:0.7;" viewBox="0 0 16 16" fill="currentColor">
                <circle cx="6" cy="5" r="2.5"/>
                <path d="M1 13c0-2.76 2.24-5 5-5s5 2.24 5 5H1z"/>
                <circle cx="12" cy="5" r="2" opacity=".6"/>
                <path d="M10.5 13c0-1.76.72-3.35 1.87-4.5A4.98 4.98 0 0115 13h-4.5z" opacity=".6"/>
            </svg>
            Membres
            <span class="users-count-badge">{{ $users->count() }}</span>
            <svg class="toggle-arrow" viewBox="0 0 16 16" fill="currentColor">
                <path d="M4 6l4 4 4-4"/>
            </svg>
        </button>

        {{-- Collapsible users list --}}
        <div class="users-list {{ $selectedUserId ? 'open' : '' }}" id="usersList">
            @forelse($users as $u)
                @include('kanban.partials.user-nav-item', ['u' => $u])
            @empty
                <p style="font-size:0.76rem; color:var(--text3); padding: 0.4rem 1.5rem;">Aucun utilisateur</p>
            @endforelse
        </div>
    </div>

    {{-- Profile & Logout --}}
    <div class="sidebar-bottom">
        <div class="profile-row">
            <div class="profile-avatar" style="overflow:hidden">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
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
            <button type="submit" class="btn-logout">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
                Se déconnecter
            </button>
        </form>
    </div>
</aside>
