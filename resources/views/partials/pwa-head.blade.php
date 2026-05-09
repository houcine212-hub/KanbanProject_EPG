{{-- ════════════════════════════════════════════════
     resources/views/partials/pwa-head.blade.php
     @include('partials.pwa-head') في كل صفحة رئيسية
     ════════════════════════════════════════════════ --}}

{{-- Manifest --}}
<link rel="manifest" href="/manifest.json">

{{-- Theme color --}}
<meta name="theme-color" content="#0055b3">
<meta name="msapplication-TileColor" content="#0055b3">
<meta name="msapplication-TileImage" content="/icons/icon-192x192.png">

{{-- iOS (Safari) PWA --}}
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="EPG Kanban">
<link rel="apple-touch-icon" href="/icons/icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-192x192.png">

{{-- Splash screen iOS --}}
<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="/icons/icon-96x96.png" type="image/png">

{{-- Service Worker Registration --}}
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('[EPG PWA] SW registered:', reg.scope))
                .catch(err => console.warn('[EPG PWA] SW error:', err));
        });
    }
</script>
