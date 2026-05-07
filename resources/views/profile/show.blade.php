<!DOCTYPE html>
<html lang="ar" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Profile — EPG Kanban</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:         #f0f4f9;
            --surface:    #ffffff;
            --surface2:   #f4f7fb;
            --border:     #dde3ed;
            --border2:    #c5d0e0;
            --text:       #0d1b2e;
            --text2:      #4a5e78;
            --text3:      #8fa3bc;
            --accent:     #0055b3;
            --accent2:    #1a70d4;
            --accent-bg:  rgba(0,85,179,0.07);
            --accent-bg2: rgba(0,85,179,0.14);
            --sidebar-w:  256px;
            --topbar-h:   56px;
            --success:    #10b981;
            --danger:     #ef4444;
        }

        [data-theme="dark"] {
            --bg:         #07090e;
            --surface:    #0d1117;
            --surface2:   #131a24;
            --border:     #1c2636;
            --border2:    #263042;
            --text:       #e2eaf5;
            --text2:      #7a90ab;
            --text3:      #3d5068;
            --accent:     #1a70d4;
            --accent2:    #4d9de8;
            --accent-bg:  rgba(26,112,212,0.1);
            --accent-bg2: rgba(26,112,212,0.2);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            transition: background 0.2s, color 0.2s;
        }

        /* ── SIDEBAR (same as dashboard) ── */
        .sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
        }

        .sidebar-logo {
            padding: 0 1.1rem;
            height: var(--topbar-h);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
        }

        .epg-logo { display: flex; align-items: center; gap: 0.55rem; text-decoration: none; }

        .epg-logo-icon {
            width: 34px; height: 34px;
            background: linear-gradient(145deg, #0055b3, #1a70d4);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(0,85,179,0.35);
        }

        .epg-logo-icon svg { width: 20px; height: 20px; fill: white; }
        .epg-logo-text { display: flex; flex-direction: column; line-height: 1.1; }
        .epg-logo-name { font-size: 0.88rem; font-weight: 700; color: var(--accent); letter-spacing: 0.04em; }
        .epg-logo-sub  { font-size: 0.6rem; font-weight: 500; color: var(--text3); letter-spacing: 0.06em; text-transform: uppercase; }

        .sidebar-nav { flex: 1; padding: 0.75rem 0.75rem 0; }

        .nav-section-label {
            font-size: 0.65rem; font-weight: 700; color: var(--text3);
            text-transform: uppercase; letter-spacing: 0.12em;
            padding: 0.6rem 0.4rem 0.35rem; margin-top: 0.2rem;
        }

        .nav-item {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.52rem 0.7rem; border-radius: 8px;
            font-size: 0.84rem; font-weight: 500; color: var(--text2);
            cursor: pointer; transition: all 0.15s; text-decoration: none;
            margin-bottom: 0.1rem;
        }

        .nav-item:hover { background: var(--surface2); color: var(--text); }
        .nav-item.active { background: var(--accent-bg); color: var(--accent2); font-weight: 600; }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.7; }
        .nav-item.active svg { opacity: 1; }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding: 0.85rem 0.75rem;
        }

        .profile-row {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.3rem 0.25rem 0.65rem;
        }

        .profile-avatar-sm {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700; color: white;
            flex-shrink: 0; overflow: hidden;
            background: linear-gradient(135deg, #0055b3, #1a70d4);
        }

        .profile-avatar-sm img { width: 100%; height: 100%; object-fit: cover; }
        .profile-info { flex: 1; min-width: 0; }
        .profile-name { font-size: 0.8rem; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .profile-role { font-size: 0.65rem; color: var(--accent2); font-weight: 500; }

        .btn-logout {
            width: 100%; padding: 0.5rem;
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 8px; color: var(--text2);
            font-size: 0.8rem; font-weight: 500; cursor: pointer;
            transition: all 0.15s; font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
        }

        .btn-logout:hover { background: rgba(220,38,38,0.08); border-color: rgba(220,38,38,0.25); color: #ef4444; }

        /* ── MAIN ── */
        .main { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; }

        .topbar {
            height: var(--topbar-h);
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: var(--surface); flex-shrink: 0;
        }

        .topbar-title { font-size: 1rem; font-weight: 700; color: var(--text); }
        .topbar-sub   { font-size: 0.75rem; color: var(--text3); margin-top: 0.1rem; }
        .topbar-right { display: flex; align-items: center; gap: 0.65rem; }

        .theme-toggle {
            width: 36px; height: 36px;
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 9px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text2); transition: all 0.15s;
        }

        .theme-toggle:hover { background: var(--border); color: var(--text); }
        .theme-toggle svg { width: 16px; height: 16px; }

        /* ── CONTENT ── */
        .content { flex: 1; overflow-y: auto; padding: 2rem 1.5rem; }

        /* ── PROFILE LAYOUT ── */
        .profile-layout {
            max-width: 820px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        @media (max-width: 760px) {
            .profile-layout { grid-template-columns: 1fr; }
        }

        /* ── PROFILE CARD ── */
        .profile-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

        /* Cover strip */
        .profile-cover {
            height: 90px;
            background: linear-gradient(135deg, #0047a0 0%, #1a70d4 50%, #4d9de8 100%);
            position: relative;
        }

        .profile-cover-pattern {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }

        /* Avatar area */
        .profile-ava-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 1.5rem 1.5rem;
            margin-top: -42px;
        }

        .profile-ava-ring {
            width: 84px; height: 84px;
            border-radius: 50%;
            border: 3px solid var(--surface);
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);
            position: relative;
            cursor: pointer;
            overflow: hidden;
            background: linear-gradient(135deg, #0055b3, #1a70d4);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; font-weight: 700; color: white;
        }

        .profile-ava-ring img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }

        .profile-ava-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.45);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.2s;
            border-radius: 50%;
        }

        .profile-ava-ring:hover .profile-ava-overlay { opacity: 1; }
        .profile-ava-overlay svg { width: 22px; height: 22px; color: white; }

        .profile-ava-hint {
            font-size: 0.72rem;
            color: var(--text3);
            margin-top: 0.5rem;
            text-align: center;
        }

        .profile-display-name {
            margin-top: 0.6rem;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            text-align: center;
        }

        .profile-display-email {
            font-size: 0.78rem;
            color: var(--text3);
            text-align: center;
            margin-top: 0.2rem;
        }

        .profile-role-badge {
            margin-top: 0.6rem;
            padding: 0.22rem 0.75rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .role-admin { background: rgba(0,85,179,0.12); color: var(--accent2); }
        .role-user  { background: rgba(16,185,129,0.12); color: #10b981; }

        /* stats in profile card */
        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin: 1.25rem 1.25rem 0;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
        }

        .pstat {
            background: var(--surface2);
            border-radius: 10px;
            padding: 0.75rem;
            text-align: center;
        }

        .pstat-val { font-size: 1.3rem; font-weight: 700; color: var(--text); }
        .pstat-lbl { font-size: 0.7rem; color: var(--text3); font-weight: 500; margin-top: 0.15rem; }

        /* ── FORMS AREA ── */
        .forms-col {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

        .form-card-header {
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid var(--border);
        }

        .form-card-title { font-size: 0.95rem; font-weight: 700; color: var(--text); }
        .form-card-sub   { font-size: 0.78rem; color: var(--text3); margin-top: 0.2rem; }

        .form-card-body { padding: 1.4rem; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 540px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 1.1rem; }
        .form-group:last-child { margin-bottom: 0; }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text2);
            margin-bottom: 0.4rem;
        }

        .form-control {
            width: 100%;
            padding: 0.68rem 0.95rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-bg2);
        }

        .form-control:read-only {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .form-hint { font-size: 0.73rem; color: var(--text3); margin-top: 0.3rem; }

        /* Alerts */
        .alert {
            padding: 0.7rem 1rem;
            border-radius: 10px;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert svg { width: 15px; height: 15px; flex-shrink: 0; }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #10b981; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #ef4444; }

        /* Buttons */
        .btn {
            padding: 0.55rem 1.1rem;
            border-radius: 9px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-primary   { background: var(--accent); color: white; }
        .btn-primary:hover { background: #0047a0; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,85,179,0.28); }
        .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--border); color: var(--text); }
        .btn-danger { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
        .btn-danger:hover { background: rgba(239,68,68,0.18); }

        .form-card-footer {
            padding: 1rem 1.4rem;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .divider-text {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0;
            font-size: 0.75rem;
            color: var(--text3);
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Hidden file input trigger */
        #avatarInput { display: none; }

        /* Password strength */
        .pwd-strength {
            margin-top: 0.5rem;
            display: flex;
            gap: 4px;
        }

        .pwd-bar {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: var(--border);
            transition: background 0.3s;
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<div class="sidebar">
    <div class="sidebar-logo">
        <a href="#" class="epg-logo">
            <div class="epg-logo-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="11" rx="1.5"/><rect x="3" y="17" width="7" height="4" rx="1.5"/><rect x="14" y="3" width="7" height="4" rx="1.5"/><rect x="14" y="10" width="7" height="11" rx="1.5"/></svg>
            </div>
            <div class="epg-logo-text">
                <span class="epg-logo-name">EPG.MA</span>
                <span class="epg-logo-sub">Kanban</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>

        <a href="{{ route('kanban.index') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="11" rx="1.5"/><rect x="3" y="17" width="7" height="4" rx="1.5"/><rect x="14" y="3" width="7" height="4" rx="1.5"/><rect x="14" y="10" width="7" height="11" rx="1.5"/></svg>
            Kanban Board
        </a>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        @endif

        <div class="nav-section-label">Account</div>

        <a href="{{ route('profile') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            My Profile
        </a>
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
            <button type="submit" class="btn-logout">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</div>

<!-- ── MAIN ── -->
<div class="main">
    <div class="topbar">
        <div>
            <div class="topbar-title">My Profile</div>
            <div class="topbar-sub">Manage your account settings</div>
        </div>
        <div class="topbar-right">
            <button class="theme-toggle" id="themeToggle" title="Toggle dark mode">
                <svg id="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none">
                    <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <svg id="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="content">
        <div class="profile-layout">

            <!-- ── LEFT: Profile Card ── -->
            <div class="profile-card">
                <div class="profile-cover">
                    <div class="profile-cover-pattern"></div>
                </div>
                <div class="profile-ava-wrap">
                    <div class="profile-ava-ring" onclick="document.getElementById('avatarInput').click()">
                        @if(auth()->user()->avatar)
                            <img id="avatarPreview" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                        @else
                            <span id="avatarInitial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <img id="avatarPreview" src="" alt="" style="display:none">
                        @endif
                        <div class="profile-ava-overlay">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="profile-ava-hint">Click to change photo</div>

                    <div class="profile-display-name">{{ auth()->user()->name }}</div>
                    <div class="profile-display-email">{{ auth()->user()->email }}</div>
                    <span class="profile-role-badge {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-user' }}">
                        {{ auth()->user()->isAdmin() ? 'Admin' : 'Member' }}
                    </span>
                </div>

                <div class="profile-stats">
                    <div class="pstat">
                        <div class="pstat-val">{{ auth()->user()->tasks()->count() }}</div>
                        <div class="pstat-lbl">Tasks</div>
                    </div>
                    <div class="pstat">
                        <div class="pstat-val">{{ auth()->user()->tasks()->where('priority','high')->count() }}</div>
                        <div class="pstat-lbl">High Priority</div>
                    </div>
                    <div class="pstat" style="grid-column: span 2">
                        <div class="pstat-val" style="font-size:0.9rem">{{ auth()->user()->created_at->format('M Y') }}</div>
                        <div class="pstat-lbl">Member since</div>
                    </div>
                </div>
                <div style="height: 1.25rem"></div>
            </div>

            <!-- ── RIGHT: Forms ── -->
            <div class="forms-col">

                @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
                @endif

                <!-- Avatar Upload (hidden, triggers via JS) -->
                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf @method('PATCH')
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                </form>

                <!-- Edit Profile -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-title">Personal Information</div>
                        <div class="form-card-sub">Update your name and email address</div>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="form-card-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                        </div>
                        <div class="form-card-footer">
                            <span class="form-hint">Changes apply immediately</span>
                            <button type="submit" class="btn btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17,21 17,13 7,13 7,21"/><polyline points="7,3 7,8 15,8"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-title">Change Password</div>
                        <div class="form-card-sub">Use a strong password of at least 8 characters</div>
                    </div>
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="form-card-body">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required id="newPassword" oninput="checkStrength(this.value)">
                                <div class="pwd-strength">
                                    <div class="pwd-bar" id="bar1"></div>
                                    <div class="pwd-bar" id="bar2"></div>
                                    <div class="pwd-bar" id="bar3"></div>
                                    <div class="pwd-bar" id="bar4"></div>
                                </div>
                                <div class="form-hint" id="strengthLabel"></div>
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password" required>
                            </div>
                        </div>
                        <div class="form-card-footer">
                            <span class="form-hint">You'll stay logged in after changing</span>
                            <button type="submit" class="btn btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="width:13px;height:13px"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div><!-- end .forms-col -->
        </div>
    </div><!-- end .content -->
</div><!-- end .main -->

<script>
    // Theme
    const html = document.documentElement;
    const saved = localStorage.getItem('epg-theme') || 'light';
    html.setAttribute('data-theme', saved);
    updateThemeIcon(saved);

    document.getElementById('themeToggle').addEventListener('click', () => {
        const curr = html.getAttribute('data-theme');
        const next = curr === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('epg-theme', next);
        updateThemeIcon(next);
    });

    function updateThemeIcon(theme) {
        document.getElementById('icon-sun').style.display  = theme === 'dark'  ? 'block' : 'none';
        document.getElementById('icon-moon').style.display = theme === 'light' ? 'block' : 'none';
    }

    // Avatar preview + auto-submit
    function previewAvatar(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            const initial = document.getElementById('avatarInitial');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initial) initial.style.display = 'none';

            // Also update sidebar avatar
            document.querySelectorAll('.profile-avatar-sm img').forEach(img => {
                img.src = e.target.result;
                img.style.display = 'block';
            });
        };
        reader.readAsDataURL(input.files[0]);
        // Auto submit
        document.getElementById('avatarForm').submit();
    }

    // Password strength
    function checkStrength(val) {
        const bars = [
            document.getElementById('bar1'),
            document.getElementById('bar2'),
            document.getElementById('bar3'),
            document.getElementById('bar4'),
        ];
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const colors = ['#ef4444','#f59e0b','#f59e0b','#10b981'];
        const labels = ['Weak','Fair','Good','Strong'];
        bars.forEach((b, i) => {
            b.style.background = i < score ? colors[score - 1] : 'var(--border)';
        });
        label.textContent = val.length > 0 ? labels[score - 1] || '' : '';
        label.style.color = score > 0 ? colors[score - 1] : 'var(--text3)';
    }
</script>
</body>
</html>