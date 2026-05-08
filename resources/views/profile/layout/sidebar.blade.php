<div class="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('kanban.index') }}" class="epg-logo">
            <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG">
            <div class="epg-logo-text">
                <span class="epg-logo-name">EPG <span>Kanban</span></span>
                <span class="epg-logo-sub">Task Management</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>

        <a href="{{ route('kanban.index') }}" class="nav-item">Kanban Board</a>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-item">Dashboard</a>
        @endif

        <div class="nav-section-label">Account</div>

        <a href="{{ route('profile') }}" class="nav-item active">My Profile</a>
    </nav>

    <div class="sidebar-bottom">
        <div class="profile-row">
            <div class="profile-avatar-sm">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ auth()->user()->name }}</div>
                <div class="profile-role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Member' }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">تسجيل الخروج</button>
        </form>
    </div>
</div>