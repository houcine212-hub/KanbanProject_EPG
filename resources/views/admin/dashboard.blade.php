<!DOCTYPE html>
<html lang="ar" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard — EPG Kanban</title>
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
            --warning:    #f59e0b;
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

        /* ── SIDEBAR ── */
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
            flex-shrink: 0;
        }

        .epg-logo {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            text-decoration: none;
        }

        .epg-logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(145deg, #0055b3, #1a70d4);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,85,179,0.35);
        }

        .epg-logo-icon svg { width: 20px; height: 20px; fill: white; }

        .epg-logo-text { display: flex; flex-direction: column; line-height: 1.1; }
        .epg-logo-name { font-size: 0.88rem; font-weight: 700; color: var(--accent); letter-spacing: 0.04em; }
        .epg-logo-sub  { font-size: 0.6rem; font-weight: 500; color: var(--text3); letter-spacing: 0.06em; text-transform: uppercase; }

        .sidebar-nav { flex: 1; padding: 0.75rem 0.75rem 0; overflow-y: auto; }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text3);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 0.6rem 0.4rem 0.35rem;
            margin-top: 0.2rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.52rem 0.7rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            margin-bottom: 0.1rem;
        }

        .nav-item:hover { background: var(--surface2); color: var(--text); }
        .nav-item.active { background: var(--accent-bg); color: var(--accent2); font-weight: 600; }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.7; }
        .nav-item.active svg { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            background: var(--surface2);
            color: var(--text3);
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.1rem 0.42rem;
            border-radius: 999px;
        }

        .nav-item.active .nav-badge { background: var(--accent-bg2); color: var(--accent2); }

        /* Sidebar bottom */
        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding: 0.85rem 0.75rem;
            flex-shrink: 0;
        }

        .profile-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.3rem 0.25rem 0.65rem;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #0055b3, #1a70d4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            overflow: hidden;
        }

        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .profile-info { flex: 1; min-width: 0; }
        .profile-name { font-size: 0.8rem; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .profile-role { font-size: 0.65rem; color: var(--accent2); font-weight: 500; }

        .btn-logout {
            width: 100%;
            padding: 0.5rem;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text2);
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-logout:hover { background: rgba(220,38,38,0.08); border-color: rgba(220,38,38,0.25); color: #ef4444; }

        /* ── MAIN ── */
        .main { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; }

        .topbar {
            height: var(--topbar-h);
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface);
            flex-shrink: 0;
        }

        .topbar-title { font-size: 1rem; font-weight: 700; color: var(--text); }
        .topbar-sub   { font-size: 0.75rem; color: var(--text3); margin-top: 0.1rem; }

        .topbar-right { display: flex; align-items: center; gap: 0.65rem; }

        /* Dark mode toggle */
        .theme-toggle {
            width: 36px;
            height: 36px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text2);
            transition: all 0.15s;
            flex-shrink: 0;
        }

        .theme-toggle:hover { background: var(--border); color: var(--text); }
        .theme-toggle svg { width: 16px; height: 16px; }

        /* ── CONTENT ── */
        .content { flex: 1; overflow-y: auto; padding: 1.5rem; }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem 1.4rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg { width: 20px; height: 20px; }
        .stat-icon.blue   { background: rgba(0,85,179,0.1);  color: var(--accent2); }
        .stat-icon.green  { background: rgba(16,185,129,0.1); color: var(--success); }
        .stat-icon.orange { background: rgba(245,158,11,0.1); color: var(--warning); }
        .stat-icon.red    { background: rgba(239,68,68,0.1);  color: var(--danger); }

        .stat-info { flex: 1; }
        .stat-value { font-size: 1.65rem; font-weight: 700; color: var(--text); line-height: 1; margin-bottom: 0.3rem; }
        .stat-label { font-size: 0.78rem; color: var(--text3); font-weight: 500; }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            margin-top: 0.5rem;
        }

        .section-title { font-size: 0.92rem; font-weight: 700; color: var(--text); }

        /* ── GRID 2 COL ── */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 900px) { .grid-2 { grid-template-columns: 1fr; } }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .table-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-card-title { font-size: 0.88rem; font-weight: 700; color: var(--text); }

        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
        }

        .badge-blue   { background: var(--accent-bg2); color: var(--accent2); }
        .badge-green  { background: rgba(16,185,129,0.12); color: var(--success); }
        .badge-orange { background: rgba(245,158,11,0.12); color: var(--warning); }
        .badge-red    { background: rgba(239,68,68,0.12);  color: var(--danger); }
        .badge-gray   { background: var(--surface2); color: var(--text3); }

        table { width: 100%; border-collapse: collapse; }

        th {
            padding: 0.65rem 1.25rem;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text3);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: var(--surface2);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 0.8rem 1.25rem;
            font-size: 0.82rem;
            color: var(--text2);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--surface2); }

        .user-cell { display: flex; align-items: center; gap: 0.65rem; }

        .user-ava {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-ava img { width: 100%; height: 100%; object-fit: cover; }

        .user-cell-info .name  { font-weight: 600; color: var(--text); font-size: 0.82rem; }
        .user-cell-info .email { font-size: 0.73rem; color: var(--text3); }

        /* Priority dot */
        .priority-dot {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.78rem;
            font-weight: 500;
        }

        .priority-dot::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .priority-dot.high   { color: var(--danger);  }
        .priority-dot.high::before   { background: var(--danger); }
        .priority-dot.medium { color: var(--warning); }
        .priority-dot.medium::before { background: var(--warning); }
        .priority-dot.low    { color: var(--success); }
        .priority-dot.low::before    { background: var(--success); }

        /* ── COLUMN MANAGEMENT ── */
        .columns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0.75rem;
            padding: 1.25rem;
        }

        .column-chip {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
        }

        .column-color-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .column-chip-count { margin-left: auto; font-size: 0.75rem; color: var(--text3); font-weight: 600; }

        .del-col-btn {
            margin-left: 0.25rem;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text3);
            padding: 0.15rem;
            border-radius: 4px;
            line-height: 0;
            transition: color 0.15s;
        }

        .del-col-btn:hover { color: var(--danger); }
        .del-col-btn svg { width: 13px; height: 13px; }

        /* Btn */
        .btn {
            padding: 0.45rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
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
        .btn-primary:hover { background: #0047a0; transform: translateY(-1px); }
        .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--border); color: var(--text); }
        .btn-danger { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
        .btn-danger:hover { background: rgba(239,68,68,0.18); }
        .btn svg { width: 14px; height: 14px; }

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(3px);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .modal-overlay.active { opacity: 1; pointer-events: all; }

        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 420px;
            max-width: 92vw;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            transform: translateY(12px) scale(0.97);
            transition: transform 0.2s;
        }

        .modal-overlay.active .modal { transform: translateY(0) scale(1); }

        .modal-header {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title { font-size: 0.95rem; font-weight: 700; color: var(--text); }

        .modal-close {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 7px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text3);
            font-size: 1rem;
            transition: all 0.15s;
        }

        .modal-close:hover { color: var(--danger); border-color: rgba(239,68,68,0.3); }

        .modal-body { padding: 1.25rem; }
        .modal-footer { padding: 1rem 1.25rem; border-top: 1px solid var(--border); display: flex; gap: 0.5rem; justify-content: flex-end; }

        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--text2); margin-bottom: 0.4rem; }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.9rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-bg2);
        }

        /* progress bar */
        .progress-bar-wrap {
            height: 6px;
            background: var(--surface2);
            border-radius: 99px;
            overflow: hidden;
            margin-top: 0.35rem;
        }

        .progress-bar {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            transition: width 0.4s ease;
        }

        /* empty state */
        .empty-state {
            padding: 2.5rem;
            text-align: center;
            color: var(--text3);
            font-size: 0.85rem;
        }

        .link-btn {
            background: none;
            border: none;
            color: var(--accent2);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .link-btn:hover { text-decoration: underline; }
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

        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div class="nav-section-label">Management</div>

        <a href="{{ route('admin.dashboard') }}#users" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
            <span class="nav-badge">{{ $usersCount }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#tasks" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            Tasks
            <span class="nav-badge">{{ $totalTasks }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#columns" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            Columns
            <span class="nav-badge">{{ $columns->count() }}</span>
        </a>

        <div class="nav-section-label">Account</div>

        <a href="{{ route('profile') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
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
            <div class="topbar-title">Admin Dashboard</div>
            <div class="topbar-sub">Overview & management</div>
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

            <button class="btn btn-primary" onclick="openModal('addColumnModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Column
            </button>
        </div>
    </div>

    <div class="content">

        <!-- ── STATS ── -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $usersCount }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalTasks }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $highPriorityTasks }}</div>
                    <div class="stat-label">High Priority</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="11" rx="1.5"/><rect x="3" y="17" width="7" height="4" rx="1.5"/><rect x="14" y="3" width="7" height="4" rx="1.5"/><rect x="14" y="10" width="7" height="11" rx="1.5"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $columns->count() }}</div>
                    <div class="stat-label">Board Columns</div>
                </div>
            </div>
        </div>

        <!-- ── USERS + TASKS ── -->
        <div class="grid-2">
            <!-- Users -->
            <div class="table-card" id="users">
                <div class="table-card-header">
                    <span class="table-card-title">Users</span>
                    <span class="badge badge-blue">{{ $usersCount }} total</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Tasks</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-ava" style="background: linear-gradient(135deg, hsl({{ (ord($u->name[0]) * 47) % 360 }},60%,45%), hsl({{ (ord($u->name[0]) * 47 + 40) % 360 }},55%,40%))">
                                        @if($u->avatar)
                                            <img src="{{ asset('storage/' . $u->avatar) }}" alt="">
                                        @else
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="user-cell-info">
                                        <div class="name">{{ $u->name }}</div>
                                        <div class="email">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-blue">{{ $u->tasks_count }}</span>
                            </td>
                            <td style="min-width: 100px">
                                @php
                                    $pct = $totalTasks > 0 ? round(($u->tasks_count / $totalTasks) * 100) : 0;
                                @endphp
                                <span style="font-size:0.75rem;color:var(--text3)">{{ $pct }}%</span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" style="width: {{ $pct }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="empty-state">No users yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Columns management -->
            <div class="table-card" id="columns">
                <div class="table-card-header">
                    <span class="table-card-title">Board Columns</span>
                    <button class="btn btn-primary" style="padding:0.35rem 0.8rem;font-size:0.75rem" onclick="openModal('addColumnModal')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Add
                    </button>
                </div>
                <div class="columns-grid">
                    @foreach($columns as $col)
                    <div class="column-chip">
                        <span class="column-color-dot" style="background: {{ $col->color }}"></span>
                        <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $col->name }}</span>
                        <span class="column-chip-count">{{ $col->tasks->count() }}</span>
                        <form action="{{ route('kanban.columns.destroy', $col) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="del-col-btn" title="Delete column" onclick="return confirm('Delete this column?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ── RECENT TASKS ── -->
        <div class="table-card" id="tasks">
            <div class="table-card-header">
                <span class="table-card-title">Recent Tasks</span>
                <span class="badge badge-gray">{{ $totalTasks }} total</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Column</th>
                        <th>Priority</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTasks as $task)
                    <tr>
                        <td style="color:var(--text);font-weight:500;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $task->title }}</td>
                        <td>
                            @if($task->user)
                            <div class="user-cell">
                                <div class="user-ava" style="width:24px;height:24px;font-size:0.62rem;background:linear-gradient(135deg,hsl({{ (ord($task->user->name[0]) * 47) % 360 }},60%,45%),hsl({{ (ord($task->user->name[0]) * 47 + 40) % 360 }},55%,40%))">
                                    @if($task->user->avatar)
                                        <img src="{{ asset('storage/' . $task->user->avatar) }}" alt="">
                                    @else
                                        {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                    @endif
                                </div>
                                {{ $task->user->name }}
                            </div>
                            @else
                                <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-blue" style="background:{{ $task->column->color }}22;color:{{ $task->column->color }}">
                                {{ $task->column->name }}
                            </span>
                        </td>
                        <td><span class="priority-dot {{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                        <td style="color:var(--text3);font-size:0.75rem">{{ $task->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('kanban.tasks.destroy', $task) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:0.28rem 0.6rem;font-size:0.72rem" onclick="return confirm('Delete task?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="empty-state">No tasks yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div><!-- end .content -->
</div><!-- end .main -->

<!-- ── ADD COLUMN MODAL ── -->
<div class="modal-overlay" id="addColumnModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Add Column</span>
            <button class="modal-close" onclick="closeModal('addColumnModal')">&#215;</button>
        </div>
        <form action="{{ route('kanban.columns.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Column Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. In Review" required>
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="color" name="color" class="form-control" value="#0055b3" style="height:44px;padding:0.3rem 0.5rem;cursor:pointer">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addColumnModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Column</button>
            </div>
        </form>
    </div>
</div>

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

    // Modals
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    document.querySelectorAll('.modal-overlay').forEach(o => {
        o.addEventListener('click', e => { if (e.target === o) o.classList.remove('active'); });
    });
</script>
</body>
</html>