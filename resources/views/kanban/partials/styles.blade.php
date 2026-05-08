<style>
    /* ═══════════════════════════════════════════════
       EPG.MA DESIGN SYSTEM — Blue & White / Dark Blue & Black
    ═══════════════════════════════════════════════ */
    :root {
        /* Light mode */
        --bg:        #e1e4e6;
        --surface:   #ffffff;
        --surface2:  #f2faf5;
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
    }

    /* ── SIDEBAR ── */
    .sidebar {
        width: var(--sidebar-w);
        min-width: var(--sidebar-w);
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-right: 1px solid rgba(200,220,210,0.55);
        box-shadow: 4px 0 28px rgba(0,0,0,0.07);
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        overflow-y: auto;
        z-index: 10;
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
        line-height: 1.15;
    }

    .epg-logo-name {
        font-size: 0.92rem;
        font-weight: 800;
        color: var(--accent);
        letter-spacing: 0.01em;
    }

    .epg-logo-name span {
        color: var(--text3);
        font-weight: 600;
        font-size: 0.82rem;
    }

    .epg-logo-sub {
        font-size: 0.58rem;
        font-weight: 500;
        color: var(--text3);
        letter-spacing: 0.07em;
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
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 50%;
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
        overflow: hidden;
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

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
        min-width: 0;
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
        flex-shrink: 0;
    }

    .topbar-user-name {
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text2);
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
        border: 1.5px solid var(--border2);
        box-shadow: 0 1px 4px rgba(0,0,0,0.12);
    }

    [data-theme="dark"] .theme-switch { background: var(--accent); border-color: var(--accent); }

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

    .btn-pill {
        padding: 0.28rem 0.75rem;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 700;
        cursor: pointer;
        border: 1.5px solid var(--border2);
        background: var(--surface);
        color: var(--text2);
        transition: all 0.18s;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        letter-spacing: 0.01em;
        text-decoration: none;
    }

    .btn-pill:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: var(--accent-bg);
        transform: translateY(-1px);
    }

    .btn-pill-accent {
        border-color: var(--accent);
        color: var(--accent);
        background: transparent;
    }

    .btn-pill-accent:hover {
        background: var(--accent);
        color: white;
        box-shadow: 0 4px 14px rgba(0,85,179,0.22);
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
        overflow-y: hidden;
        min-height: 0;
    }

    .board {
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
        height: 100%;
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
        max-height: calc(100vh - var(--topbar-h) - 2.5rem);
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon:hover {
        background: #fff0f0;
        color: #dc2626;
    }

    [data-theme="dark"] .btn-icon:hover {
        background: rgba(220,38,38,0.1);
        color: #f87171;
    }

    .btn-icon.edit:hover {
        background: var(--accent-bg);
        color: var(--accent2);
    }
    [data-theme="dark"] .btn-icon.edit:hover {
        background: var(--accent-bg);
        color: var(--accent2);
    }

    .task-list {
        padding: 0.6rem;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        min-height: 52px;
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
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
        width: 20px;
        height: 20px;
        border-radius: 50%;
        font-size: 0.58rem;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 0 0 1.5px var(--surface), 0 0 0 2.5px var(--border2);
    }

    .task-owner-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 50%;
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

    /* Add Task button */
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