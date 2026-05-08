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

        <a href="{{ route('kanban.index') }}" class="nav-item">
            Kanban Board
        </a>

        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            Dashboard
        </a>

        <div class="nav-section-label">Management</div>

        <a href="{{ route('admin.dashboard') }}#users" class="nav-item">
            Users
            <span class="nav-badge">{{ $usersCount }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#tasks" class="nav-item">
            Tasks
            <span class="nav-badge">{{ $totalTasks }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#columns" class="nav-item">
            Columns
            <span class="nav-badge">{{ $columns->count() }}</span>
        </a>

        <div class="nav-section-label">Account</div>

        <a href="{{ route('profile') }}" class="nav-item">
            My Profile
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
                <div class="profile-role">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">تسجيل الخروج</button>
        </form>
    </div>
</div>