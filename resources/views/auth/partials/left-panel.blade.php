<div class="left-content">
    <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG" class="left-logo">
    <div class="left-title">{{ $title ?? 'EPG Kanban' }}</div>
    <div class="left-sub">{{ $subtitle ?? 'منصة إدارة المهام' }}</div>
    <div class="left-divider"></div>
    
    {{ $slot ?? '' }}
</div>