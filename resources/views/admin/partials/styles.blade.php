<style>
    :root {
        --bg:         #e0e0e0;
        --surface:    #ffffff;
        --surface2:   #f2faf5;
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

    [data-theme="dark"] .sidebar,
    [data-theme="dark"] .topbar {
        background: rgba(7,9,14,0.75);
        border-color: rgba(255,255,255,0.05);
        box-shadow: 4px 0 28px rgba(0,0,0,0.45);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        height: 100vh;
        overflow: hidden;
        display: flex;
        transition: background 0.2s, color 0.2s;
    }

    .sidebar {
        width: var(--sidebar-w);
        min-width: var(--sidebar-w);
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-right: 1px solid rgba(200,220,210,0.55);
        box-shadow: 4px 0 28px rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        z-index: 10;
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
        gap: 0.6rem;
        text-decoration: none;
    }

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
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: inherit;
    }

    .btn-logout:hover { background: rgba(220,38,38,0.08); border-color: rgba(220,38,38,0.25); color: #ef4444; }

    .main { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; height: 100vh; }

    .topbar {
        height: var(--topbar-h);
        padding: 0 1.5rem;
        border-bottom: 1px solid rgba(200,220,210,0.55);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        flex-shrink: 0;
        z-index: 9;
        width: 100%;
        overflow: hidden;
        gap: 0.5rem;
    }

    .topbar-title { font-size: 1rem; font-weight: 700; color: var(--text); }
    .topbar-sub   { font-size: 0.75rem; color: var(--text3); margin-top: 0.1rem; }
    .topbar-right { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }

    .topbar-pill-btn {
        padding: 0.3rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        border: 1.5px solid var(--accent);
        background: transparent;
        color: var(--accent);
        transition: all 0.18s;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        letter-spacing: 0.01em;
    }

    .topbar-pill-btn:hover {
        background: var(--accent);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0,85,179,0.22);
    }

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

    .theme-toggle {
        padding: 0.4rem 0.75rem;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text2);
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: inherit;
    }

    .theme-toggle:hover { background: var(--border); color: var(--text); }

    .content { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 1.5rem; }

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
        padding: 1.4rem 1.5rem;
        border-left: 4px solid var(--accent);
    }

    .stat-card.green  { border-left-color: var(--success); }
    .stat-card.orange { border-left-color: var(--warning); }
    .stat-card.red    { border-left-color: var(--danger); }

    .stat-label { font-size: 0.75rem; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem; }
    .stat-value { font-size: 2rem; font-weight: 800; color: var(--text); line-height: 1; }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 900px) { .grid-2 { grid-template-columns: 1fr; } }

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
    .badge-gray   { background: var(--surface2); color: var(--text3); border: 1px solid var(--border); }

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
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.68rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 0 0 2px var(--surface), 0 0 0 3.5px var(--border2);
    }

    .user-ava img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%; }
    .user-cell-info .name  { font-weight: 600; color: var(--text); font-size: 0.82rem; }
    .user-cell-info .email { font-size: 0.73rem; color: var(--text3); }

    .priority-dot {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.78rem;
        font-weight: 600;
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
        padding: 0.1rem 0.25rem;
        border-radius: 4px;
        font-size: 0.9rem;
        line-height: 1;
        transition: color 0.15s;
        font-family: inherit;
    }

    .del-col-btn:hover { color: var(--danger); }

    .btn {
        padding: 0.45rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
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
    .btn-primary:hover { background: #0047a0; transform: translateY(-1px); }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--border); color: var(--text); }
    .btn-danger { background: rgba(239,68,68,0.08); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
    .btn-danger:hover { background: rgba(239,68,68,0.15); }

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
    .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text2); margin-bottom: 0.4rem; }

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

    .progress-bar-wrap {
        height: 5px;
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

    .empty-state {
        padding: 2.5rem;
        text-align: center;
        color: var(--text3);
        font-size: 0.85rem;
    }
</style>