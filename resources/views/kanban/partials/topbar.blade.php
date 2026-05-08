<div class="topbar">
    <div class="topbar-left">
        @if(!$isAdmin)
            {{-- Show brand for regular user --}}
            <div class="topbar-brand">
                <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG" style="height:30px;width:30px;object-fit:cover;border-radius:50%;">
            </div>
            <div style="width:1px;height:20px;background:var(--border);"></div>
        @endif

        <span class="topbar-title">
            @if($isAdmin && $selectedUser)
                Board of {{ $selectedUser->name }}
            @elseif($isAdmin)
                All Tasks Overview
            @else
                EPG WORKSPACE
            @endif
        </span>

        @if($isAdmin && $selectedUser)
            <div class="viewing-badge">
                <div class="dot"></div>
                Viewing: {{ $selectedUser->name }}
            </div>
        @endif
    </div>

    <div class="topbar-right">
        {{-- Dark mode toggle --}}
        <div class="theme-switch" id="themeToggle" title="Toggle dark mode">
            <div class="theme-switch-thumb"></div>
        </div>

        @if(!$isAdmin)
            <a href="{{ route('profile') }}" class="btn btn-secondary" style="padding:0.3rem 0.5rem 0.3rem 0.3rem; gap: 0.4rem;">
                <div style="width:26px;height:26px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#0055b3,#1a70d4);display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:white;">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    @endif
                </div>
                {{ auth()->user()->name }}
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">تسجيل الخروج</button>
            </form>
        @else
            <div style="display:flex;align-items:center;gap:0.4rem;padding:0 0.25rem;">
                <div style="width:28px;height:28px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#0055b3,#1a70d4);display:flex;align-items:center;justify-content:center;font-size:0.68rem;font-weight:700;color:white;border:2px solid rgba(0,85,179,0.15);">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    @endif
                </div>
                <span style="font-size:0.77rem;font-weight:600;color:var(--text2);">{{ auth()->user()->name }}</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:12px;height:12px;flex-shrink:0">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>
            <button class="btn-pill btn-pill-accent" onclick="openColumnModal()">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add Column
            </button>
        @endif
    </div>
</div>