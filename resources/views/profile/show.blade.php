<!DOCTYPE html>
<html lang="ar" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Profile — EPG Kanban</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            transition: background 0.2s, color 0.2s;
        }

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

        .epg-logo { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }

        .epg-logo img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
        }

        .epg-logo-text { display: flex; flex-direction: column; line-height: 1.15; }
        .epg-logo-name { font-size: 0.92rem; font-weight: 800; color: var(--accent); letter-spacing: 0.01em; }
        .epg-logo-name span { color: var(--text3); font-weight: 600; font-size: 0.82rem; }
        .epg-logo-sub  { font-size: 0.58rem; font-weight: 500; color: var(--text3); letter-spacing: 0.07em; text-transform: uppercase; }

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
            font-size: 0.8rem; font-weight: 600; cursor: pointer;
            transition: all 0.15s; font-family: inherit;
        }

        .btn-logout:hover { background: rgba(220,38,38,0.08); border-color: rgba(220,38,38,0.25); color: #ef4444; }

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

        /* ── Theme Toggle Switch ── */
        .theme-switch {
            width: 44px;
            height: 24px;
            background: var(--border2);
            border-radius: 999px;
            position: relative;
            cursor: pointer;
            transition: background 0.3s;
            flex-shrink: 0;
        }

        [data-theme="dark"] .theme-switch { background: var(--accent); }

        .theme-switch-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 1px 5px rgba(0,0,0,0.25);
            transition: transform 0.28s cubic-bezier(.4,0,.2,1);
        }

        [data-theme="dark"] .theme-switch-thumb { transform: translateX(20px); }

        .content { flex: 1; overflow-y: auto; padding: 2rem 1.5rem; }

        .profile-layout {
            max-width: 820px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        @media (max-width: 760px) { .profile-layout { grid-template-columns: 1fr; } }

        .profile-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

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
            font-size: 0.72rem;
            font-weight: 700;
            color: white;
            letter-spacing: 0.02em;
        }

        .profile-ava-ring:hover .profile-ava-overlay { opacity: 1; }

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

        .pstat-val { font-size: 1.3rem; font-weight: 800; color: var(--text); }
        .pstat-lbl { font-size: 0.7rem; color: var(--text3); font-weight: 500; margin-top: 0.15rem; }

        .forms-col { display: flex; flex-direction: column; gap: 1.25rem; }

        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

        .form-card-header { padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border); }
        .form-card-title { font-size: 0.95rem; font-weight: 700; color: var(--text); }
        .form-card-sub   { font-size: 0.78rem; color: var(--text3); margin-top: 0.2rem; }
        .form-card-body  { padding: 1.4rem; }

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

        .form-hint { font-size: 0.73rem; color: var(--text3); margin-top: 0.3rem; }

        .alert {
            padding: 0.7rem 1rem;
            border-radius: 10px;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
            font-weight: 500;
        }

        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #10b981; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #ef4444; }

        .btn {
            padding: 0.55rem 1.1rem;
            border-radius: 9px;
            font-size: 0.82rem;
            font-weight: 700;
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

        .form-card-footer {
            padding: 1rem 1.4rem;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #avatarInput { display: none; }

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

<div class="main">
    <div class="topbar">
        <div>
            <div class="topbar-title">My Profile</div>
            <div class="topbar-sub">Manage your account settings</div>
        </div>
        <div class="topbar-right">
            <div class="theme-switch" id="themeToggle" title="Toggle dark mode"><div class="theme-switch-thumb"></div></div>
        </div>
    </div>

    <div class="content">
        <div class="profile-layout">

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
                        <div class="profile-ava-overlay">Edit</div>
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

            <div class="forms-col">

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf @method('PATCH')
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                </form>

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
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

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
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const html = document.documentElement;
    const saved = localStorage.getItem('epg-theme') || 'light';
    html.setAttribute('data-theme', saved);

    document.getElementById('themeToggle').addEventListener('click', () => {
        const curr = html.getAttribute('data-theme');
        const next = curr === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('epg-theme', next);
    });

    function previewAvatar(input) {
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            const initial = document.getElementById('avatarInitial');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initial) initial.style.display = 'none';
            document.querySelectorAll('.profile-avatar-sm img').forEach(img => {
                img.src = e.target.result;
                img.style.display = 'block';
            });
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('avatarForm').submit();
    }

    function checkStrength(val) {
        const bars = ['bar1','bar2','bar3','bar4'].map(id => document.getElementById(id));
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const colors = ['#ef4444','#f59e0b','#f59e0b','#10b981'];
        const labels = ['Weak','Fair','Good','Strong'];
        bars.forEach((b, i) => { b.style.background = i < score ? colors[score - 1] : 'var(--border)'; });
        label.textContent = val.length > 0 ? labels[score - 1] || '' : '';
        label.style.color = score > 0 ? colors[score - 1] : 'var(--text3)';
    }
</script>
</body>
</html>