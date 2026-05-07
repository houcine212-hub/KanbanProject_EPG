<!DOCTYPE html>
<html lang="ar" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EPG Kanban Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <style>
        /* ═══════════════════════════════════════════════
           EPG.MA DESIGN SYSTEM — Blue & White / Dark Blue & Black
        ═══════════════════════════════════════════════ */
        :root {
            /* Light mode */
            --bg:        #f0f4f9;
            --surface:   #ffffff;
            --surface2:  #f4f7fb;
            --border:    #dde3ed;
            --border2:   #c5d0e0;
            --text:      #0d1b2e;
            --text2:     #4a5e78;
            --text3:     #8fa3bc;
            --accent:    #0055b3;
            --accent2:   #1a70d4;
            --accent-bg: rgba(0,85,179,0.07);
            --accent-bg2:rgba(0,85,179,0.14);
            --sidebar-w: 264px;
            --topbar-h:  56px;
        }

        [data-theme="dark"] {
            --bg:        #07090e;
            --surface:   #0d1117;
            --surface2:  #131a24;
            --border:    #1c2636;
            --border2:   #263042;
            --text:      #e2eaf5;
            --text2:     #7a90ab;
            --text3:     #3d5068;
            --accent:    #1a70d4;
            --accent2:   #4d9de8;
            --accent-bg: rgba(26,112,212,0.1);
            --accent-bg2:rgba(26,112,212,0.2);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
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
            overflow-y: auto;
        }

        /* EPG Logo Area */
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

        /* EPG logo icon: blue square with "EPG" letters style */
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

        .epg-logo-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .epg-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .epg-logo-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.04em;
        }

        .epg-logo-sub {
            font-size: 0.6rem;
            font-weight: 500;
            color: var(--text3);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0.75rem 0.75rem 0;
            overflow-y: auto;
        }

        /* Section label */
        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text3);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 0.6rem 0.4rem 0.35rem;
            margin-top: 0.2rem;
        }

        /* Nav item */
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
            user-select: none;
        }

        .nav-item:hover {
            background: var(--surface2);
            color: var(--text);
        }

        .nav-item.active {
            background: var(--accent-bg);
            color: var(--accent2);
            font-weight: 600;
        }

        .nav-item .nav-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: 0.7;
        }

        .nav-item.active .nav-icon { opacity: 1; }

        .nav-count {
            margin-left: auto;
            background: var(--surface2);
            color: var(--text3);
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.1rem 0.42rem;
            border-radius: 999px;
            min-width: 20px;
            text-align: center;
        }

        .nav-item.active .nav-count {
            background: var(--accent-bg2);
            color: var(--accent2);
        }

        /* Collapsible Users Toggle */
        .users-toggle {
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
            margin-bottom: 0.1rem;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            font-family: inherit;
        }

        .users-toggle:hover {
            background: var(--surface2);
            color: var(--text);
        }

        .users-toggle .toggle-arrow {
            margin-left: auto;
            width: 14px;
            height: 14px;
            color: var(--text3);
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .users-toggle.open .toggle-arrow {
            transform: rotate(180deg);
        }

        .users-toggle .users-count-badge {
            background: var(--surface2);
            color: var(--text3);
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.1rem 0.42rem;
            border-radius: 999px;
            min-width: 20px;
            text-align: center;
        }

        /* Users list (collapsible) */
        .users-list {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.25s ease, opacity 0.2s ease;
            opacity: 0;
        }

        .users-list.open {
            max-height: 600px;
            opacity: 1;
        }

        .user-nav-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 0.7rem 0.45rem 1.5rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            margin-bottom: 0.05rem;
        }

        .user-nav-item:hover {
            background: var(--surface2);
            color: var(--text);
        }

        .user-nav-item.active {
            background: var(--accent-bg);
            color: var(--accent2);
            font-weight: 600;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            flex-shrink: 0;
            color: white;
        }

        .user-nav-item .nav-count {
            margin-left: auto;
            background: var(--surface2);
            color: var(--text3);
            font-size: 0.68rem;
            font-weight: 600;
            padding: 0.08rem 0.38rem;
            border-radius: 999px;
        }

        .user-nav-item.active .nav-count {
            background: var(--accent-bg2);
            color: var(--accent2);
        }

        /* Sidebar Bottom */
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
        }

        .profile-info { flex: 1; min-width: 0; }

        .profile-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-role {
            font-size: 0.65rem;
            color: var(--accent2);
            font-weight: 500;
        }

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

        .btn-logout:hover {
            background: #fff0f0;
            border-color: #fca5a5;
            color: #dc2626;
        }

        [data-theme="dark"] .btn-logout:hover {
                background: rgba(220,38,38,0.1);
                border-color: rgba(220,38,38,0.25);
                color: #f87171;
            }
        }

        /* ── MAIN AREA ── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
        }

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

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Non-admin logo in topbar */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .topbar-brand-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(145deg, #0055b3, #1a70d4);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,85,179,0.3);
        }

        .topbar-brand-icon svg {
            width: 16px;
            height: 16px;
            fill: white;
        }

        .topbar-title {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text);
        }

        .viewing-badge {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--accent-bg);
            border: 1px solid var(--accent-bg2);
            padding: 0.22rem 0.65rem 0.22rem 0.4rem;
            border-radius: 999px;
            font-size: 0.75rem;
            color: var(--accent2);
            font-weight: 600;
        }

        .viewing-badge .dot {
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .topbar-user-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text2);
        }

        /* Buttons */
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

        .btn-primary {
            background: var(--accent);
            color: white;
            box-shadow: 0 1px 4px rgba(0,85,179,0.25);
        }

        .btn-primary:hover {
            background: #0047a0;
            box-shadow: 0 2px 8px rgba(0,85,179,0.35);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--surface2);
            color: var(--text2);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
            color: var(--text);
        }

        /* ── BOARD ── */
        .board-wrap {
            flex: 1;
            overflow-x: auto;
            overflow-y: auto;
        }

        .board {
            display: flex;
            gap: 1rem;
            padding: 1.25rem;
            min-height: 100%;
            align-items: flex-start;
        }

        .column {
            width: 288px;
            min-width: 288px;
            background: var(--surface);
            border-radius: 12px;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .column-header {
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            cursor: grab;
        }

        .column-header:active { cursor: grabbing; }

        .column-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text);
        }

        .column-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .column-count {
            background: var(--surface2);
            color: var(--text3);
            padding: 0.08rem 0.4rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            border: 1px solid var(--border);
        }

        .btn-icon {
            background: transparent;
            border: none;
            cursor: pointer;
            color: var(--text3);
            padding: 0.2rem 0.3rem;
            border-radius: 5px;
            font-size: 0.82rem;
            transition: all 0.15s;
            line-height: 1;
        }

        .btn-icon:hover {
            background: #fff0f0;
            color: #dc2626;
        }

        [data-theme="dark"] .btn-icon:hover {
                background: rgba(220,38,38,0.1);
                color: #f87171;
            }
        }

        .task-list {
            padding: 0.6rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            min-height: 52px;
            flex: 1;
        }

        .task-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.75rem 0.85rem;
            cursor: grab;
            transition: all 0.15s;
            user-select: none;
        }

        .task-card:hover {
            border-color: var(--border2);
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }

        [data-theme="dark"] .task-card:hover {
                box-shadow: 0 4px 14px rgba(0,0,0,0.4);
            }

        .task-card:active { cursor: grabbing; }

        .task-card.sortable-ghost {
            opacity: 0.2;
            border: 2px dashed var(--accent);
        }

        .task-card.sortable-drag {
            opacity: 0.95;
            box-shadow: 0 12px 32px rgba(0,85,179,0.2);
        }

        .task-title {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.3rem;
            line-height: 1.45;
        }

        .task-desc {
            font-size: 0.74rem;
            color: var(--text2);
            line-height: 1.55;
            margin-bottom: 0.5rem;
        }

        .task-owner-row {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.5rem;
        }

        .task-owner-avatar {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.58rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .task-owner-name {
            font-size: 0.72rem;
            color: var(--text3);
            font-weight: 500;
        }

        .task-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .task-actions { display: flex; gap: 0.3rem; }

        .priority-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.14rem 0.5rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .priority-low    { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .priority-medium { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .priority-high   { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }

        [data-theme="dark"] .priority-low    { background: #052e16; color: #4ade80; border-color: #065f46; }
        [data-theme="dark"] .priority-medium { background: #1c1500; color: #f59e0b; border-color: #92400e; }
        [data-theme="dark"] .priority-high   { background: #2d0f0f; color: #f87171; border-color: #991b1b; }

        .btn-task {
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.18rem 0.48rem;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }

        .btn-task-edit  { color: var(--accent2); border-color: rgba(26,112,212,0.25); }
        .btn-task-edit:hover { background: var(--accent-bg); }
        .btn-task-del   { color: #dc2626; border-color: rgba(220,38,38,0.2); }
        .btn-task-del:hover { background: rgba(220,38,38,0.06); }

        [data-theme="dark"] .btn-task-del { color: #f87171; }

        /* Add Task button — only for users, not admin */
        .add-task-btn {
            width: 100%;
            padding: 0.52rem;
            background: transparent;
            border: none;
            color: var(--text3);
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            border-top: 1px solid var(--border);
            transition: all 0.15s;
            border-radius: 0 0 12px 12px;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
        }

        .add-task-btn:hover {
            background: var(--accent-bg);
            color: var(--accent2);
        }

        .add-column-card {
            width: 288px;
            min-width: 288px;
            background: transparent;
            border: 2px dashed var(--border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            min-height: 80px;
            color: var(--text3);
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.2s;
            gap: 0.35rem;
        }

        .add-column-card:hover {
            border-color: var(--accent);
            color: var(--accent2);
            background: var(--accent-bg);
        }

        /* Empty state */
        .empty-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            color: var(--text3);
            gap: 0.35rem;
            text-align: center;
        }

        .empty-col svg {
            width: 28px;
            height: 28px;
            opacity: 0.4;
            margin-bottom: 0.2rem;
        }

        .empty-col p { font-size: 0.78rem; }

        /* ── MODALS ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(6px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: var(--surface);
            border: 1px solid var(--border2);
            border-radius: 16px;
            padding: 1.5rem;
            width: 420px;
            max-width: 92vw;
            box-shadow: 0 24px 64px rgba(0,0,0,0.2);
        }

        [data-theme="dark"] .modal { box-shadow: 0 24px 64px rgba(0,0,0,0.6); }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            font-size: 0.97rem;
            font-weight: 700;
            color: var(--text);
        }

        .modal-close {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text3);
            cursor: pointer;
            font-size: 0.95rem;
            width: 28px;
            height: 28px;
            border-radius: 7px;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: var(--border);
            color: var(--text);
        }

        .form-group { margin-bottom: 1rem; }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text2);
            margin-bottom: 0.4rem;
            letter-spacing: 0.01em;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.58rem 0.85rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-bg);
        }

        .form-group textarea { resize: vertical; min-height: 80px; }
        .form-group select option { background: var(--surface2); }

        .modal-footer {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            margin-top: 1.4rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .column.sortable-ghost { opacity: 0.2; }

        /* Divider in sidebar */
        .sidebar-divider {
            height: 1px;
            background: var(--border);
            margin: 0.3rem 0.75rem;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 10px; }
    </style>
</head>
<body>

@if($isAdmin)
<aside class="sidebar">
    {{-- EPG Logo --}}
    <div class="sidebar-logo">
        <div class="epg-logo">
            <div class="epg-logo-icon">
                {{-- EPG-style grid/kanban icon --}}
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="3" width="7" height="10" rx="1.5"/>
                    <rect x="3" y="16" width="7" height="5" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="5" rx="1.5"/>
                    <rect x="14" y="11" width="7" height="10" rx="1.5"/>
                </svg>
            </div>
            <div class="epg-logo-text">
                <span class="epg-logo-name">EPG</span>
                <span class="epg-logo-sub">Kanban Board</span>
            </div>
        </div>
    </div>

    <div class="sidebar-nav">
        {{-- WORKSPACE section --}}
        <div class="nav-section-label">Workspace</div>

        <a href="{{ route('kanban.index') }}"
           class="nav-item {{ !$selectedUserId ? 'active' : '' }}">
            {{-- Overview icon --}}
            <svg class="nav-icon" viewBox="0 0 16 16" fill="currentColor">
                <rect x="1" y="1" width="6" height="6" rx="1"/>
                <rect x="9" y="1" width="6" height="6" rx="1"/>
                <rect x="1" y="9" width="6" height="6" rx="1"/>
                <rect x="9" y="9" width="6" height="6" rx="1"/>
            </svg>
            All Tasks
            <span class="nav-count">{{ $users->sum('tasks_count') }}</span>
        </a>

        <div class="sidebar-divider"></div>
        <div class="nav-section-label">Users</div>

        {{-- Collapsible Users Toggle --}}
        <button class="users-toggle {{ $selectedUserId ? 'open' : '' }}"
                id="usersToggleBtn"
                onclick="toggleUsers()">
            {{-- Users icon --}}
            <svg class="nav-icon" style="width:16px;height:16px;flex-shrink:0;opacity:0.7;" viewBox="0 0 16 16" fill="currentColor">
                <circle cx="6" cy="5" r="2.5"/>
                <path d="M1 13c0-2.76 2.24-5 5-5s5 2.24 5 5H1z"/>
                <circle cx="12" cy="5" r="2" opacity=".6"/>
                <path d="M10.5 13c0-1.76.72-3.35 1.87-4.5A4.98 4.98 0 0115 13h-4.5z" opacity=".6"/>
            </svg>
            Members
            <span class="users-count-badge">{{ $users->count() }}</span>
            {{-- Chevron --}}
            <svg class="toggle-arrow" viewBox="0 0 16 16" fill="currentColor">
                <path d="M4 6l4 4 4-4"/>
            </svg>
        </button>

        {{-- Collapsible users list --}}
        <div class="users-list {{ $selectedUserId ? 'open' : '' }}" id="usersList">
            @forelse($users as $u)
            @php
                $palette = ['#0055b3','#059669','#d97706','#dc2626','#7c3aed','#0284c7','#ea580c'];
                $uc = $palette[$u->id % count($palette)];
                $ui = strtoupper(substr($u->name, 0, 1));
            @endphp
            <a href="{{ route('kanban.index', ['user_id' => $u->id]) }}"
               class="user-nav-item {{ $selectedUserId == $u->id ? 'active' : '' }}">
                <div class="user-avatar" style="background: {{ $uc }}">{{ $ui }}</div>
                <span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ $u->name }}
                </span>
                <span class="nav-count">{{ $u->tasks_count }}</span>
            </a>
            @empty
            <p style="font-size:0.76rem; color:var(--text3); padding: 0.4rem 1.5rem;">No users yet</p>
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
                <div class="profile-role">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
                تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
@endif

{{-- ── MAIN ── --}}
<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            @if(!$isAdmin)
            {{-- Show brand for regular user --}}
            <div class="topbar-brand">
                <div class="topbar-brand-icon">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="10" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="11" width="7" height="10" rx="1.5"/></svg>
                </div>
                <span style="font-size:0.82rem;font-weight:700;color:var(--accent);letter-spacing:0.04em;">EPG</span>
            </div>
            <div style="width:1px;height:20px;background:var(--border);"></div>
            @endif

            <span class="topbar-title">
                @if($isAdmin && $selectedUser)
                    Board of {{ $selectedUser->name }}
                @elseif($isAdmin)
                    All Tasks Overview
                @else
                    My Kanban Board
                @endif
            </span>

            @if($isAdmin && $selectedUser)
            @php
                $pal = ['#0055b3','#059669','#d97706','#dc2626','#7c3aed','#0284c7','#ea580c'];
            @endphp
            <div class="viewing-badge">
                <div class="dot"></div>
                Viewing: {{ $selectedUser->name }}
            </div>
            @endif
        </div>

        <div class="topbar-right">
            {{-- Dark mode toggle --}}
            <button class="btn btn-secondary" id="themeToggle" style="padding:0.4rem 0.6rem" title="Toggle dark mode">
                <svg id="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:15px;height:15px;display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                <svg id="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:15px;height:15px"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>

            @if(!$isAdmin)
                <a href="{{ route('profile') }}" class="btn btn-secondary" style="padding:0.4rem 0.75rem">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:14px;height:14px"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ auth()->user()->name }}
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">تسجيل الخروج</button>
                </form>
            @else
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="padding:0.4rem 0.75rem">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:14px;height:14px"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
                <button class="btn btn-primary" onclick="openColumnModal()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Column
                </button>
            @endif
        </div>
    </div>

    {{-- BOARD --}}
    <div class="board-wrap">
        <div class="board" id="board">
            @foreach($columns as $column)
            <div class="column" data-column-id="{{ $column->id }}">
                <div class="column-header">
                    <div class="column-title">
                        <div class="column-dot" style="background: {{ $column->color }}"></div>
                        {{ $column->name }}
                        <span class="column-count">{{ $column->tasks->count() }}</span>
                    </div>
                    @if($isAdmin)
                    <form action="{{ route('kanban.columns.destroy', $column) }}" method="POST"
                          onsubmit="return confirm('Delete column «{{ $column->name }}»?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon" title="Delete column">&#215;</button>
                    </form>
                    @endif
                </div>

                <div class="task-list" id="task-list-{{ $column->id }}" data-column="{{ $column->id }}">
                    @forelse($column->tasks as $task)
                    @php
                        $pal2 = ['#0055b3','#059669','#d97706','#dc2626','#7c3aed','#0284c7','#ea580c'];
                        $tc = $task->user ? $pal2[$task->user->id % count($pal2)] : '#8fa3bc';
                        $ti = $task->user ? strtoupper(substr($task->user->name, 0, 1)) : '?';
                    @endphp
                    <div class="task-card"
                         data-task-id="{{ $task->id }}"
                         data-title="{{ $task->title }}"
                         data-description="{{ $task->description }}"
                         data-priority="{{ $task->priority }}">

                        <div class="task-title">{{ $task->title }}</div>

                        @if($task->description)
                        <div class="task-desc">{{ Str::limit($task->description, 80) }}</div>
                        @endif

                        @if($isAdmin)
                        <div class="task-owner-row">
                            <div class="task-owner-avatar" style="background: {{ $tc }}">{{ $ti }}</div>
                            <span class="task-owner-name">{{ $task->user?->name ?? 'Unknown' }}</span>
                        </div>
                        @endif

                        <div class="task-footer">
                            <span class="priority-badge priority-{{ $task->priority }}">{{ $task->priority }}</span>
                            <div class="task-actions">
                                @if($isAdmin)
                                <button type="button" class="btn-task btn-task-edit"
                                        onclick="openEditModal(this.closest('.task-card'))">Edit</button>
                                @endif
                                @if($isAdmin || $task->user_id === auth()->id())
                                <form action="{{ route('kanban.tasks.destroy', $task) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-task btn-task-del">Delete</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-col">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <path d="M8 12h8M12 8v8"/>
                        </svg>
                        <p>No tasks yet</p>
                    </div>
                    @endforelse
                </div>

                {{-- Add Task: only for regular users, NOT admin --}}
                @if(!$isAdmin)
                <button class="add-task-btn" onclick="openTaskModal({{ $column->id }})">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Task
                </button>
                @endif
            </div>
            @endforeach

            @if($isAdmin)
            <div class="add-column-card" onclick="openColumnModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Column
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── TASK MODAL (for users only) ── --}}
@if(!$isAdmin)
<div class="modal-overlay" id="taskModal">
    <div class="modal">
        <div class="modal-header">
            <h3>New Task</h3>
            <button class="modal-close" onclick="closeModal('taskModal')">&#215;</button>
        </div>
        <form action="{{ route('kanban.tasks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kanban_column_id" id="taskColumnId">
            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" required placeholder="What needs to be done?">
            </div>
            <div class="form-group">
                <label>Description <span style="font-weight:400;color:var(--text3)">(optional)</span></label>
                <textarea name="description" placeholder="Add more details..."></textarea>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority">
                    <option value="low">🟢 Low</option>
                    <option value="medium" selected>🟡 Medium</option>
                    <option value="high">🔴 High</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('taskModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </div>
        </form>
    </div>
</div>
@endif

@if($isAdmin)
{{-- ── COLUMN MODAL (admin only) ── --}}
<div class="modal-overlay" id="columnModal">
    <div class="modal">
        <div class="modal-header">
            <h3>New Column</h3>
            <button class="modal-close" onclick="closeModal('columnModal')">&#215;</button>
        </div>
        <form action="{{ route('kanban.columns.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Column Name</label>
                <input type="text" name="name" required placeholder="e.g. In Review">
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="color" name="color" value="#0055b3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('columnModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Column</button>
            </div>
        </form>
    </div>
</div>

{{-- ── EDIT TASK MODAL (admin only) ── --}}
<div class="modal-overlay" id="editTaskModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Task</h3>
            <button class="modal-close" onclick="closeModal('editTaskModal')">&#215;</button>
        </div>
        <form id="editTaskForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" id="editTitle" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="editDescription"></textarea>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority" id="editPriority">
                    <option value="low">🟢 Low</option>
                    <option value="medium">🟡 Medium</option>
                    <option value="high">🔴 High</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editTaskModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
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
        document.getElementById('icon-sun').style.display  = saved === 'dark'  ? 'block' : 'none';
        document.getElementById('icon-moon').style.display = saved === 'light' ? 'block' : 'none';
    })();

    document.getElementById('themeToggle').addEventListener('click', () => {
        const curr = document.documentElement.getAttribute('data-theme');
        const next = curr === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('epg-theme', next);
        document.getElementById('icon-sun').style.display  = next === 'dark'  ? 'block' : 'none';
        document.getElementById('icon-moon').style.display = next === 'light' ? 'block' : 'none';
    });
</script>

</body>
</html>