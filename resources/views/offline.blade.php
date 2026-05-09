<!DOCTYPE html>
<html lang="fr" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hors ligne — EPG Kanban</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fa;
            color: #1a2332;
        }
        .card {
            text-align: center;
            padding: 3rem 2rem;
            max-width: 420px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,.1);
        }
        .icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #0055b3, #1a70d4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .icon svg { color: white; }
        h1 { font-size: 1.4rem; font-weight: 700; margin-bottom: .5rem; }
        p  { font-size: .9rem; color: #6b7a8d; line-height: 1.6; margin-bottom: 1.5rem; }
        .btn {
            display: inline-block;
            padding: .65rem 1.5rem;
            background: linear-gradient(135deg, #0055b3, #1a70d4);
            color: white;
            border-radius: 10px;
            font-weight: 600;
            font-size: .88rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: inherit;
        }
        .logo { font-size: .75rem; color: #aab; margin-top: 1.5rem; font-weight: 600; letter-spacing: .05em; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <line x1="1" y1="1" x2="23" y2="23"/>
                <path d="M16.72 11.06A10.94 10.94 0 0119 12.55M5 12.55a10.94 10.94 0 015.17-2.39M10.71 5.05A16 16 0 0122.56 9M1.42 9a15.91 15.91 0 014.7-2.88M8.53 16.11a6 6 0 016.95 0M12 20h.01"/>
            </svg>
        </div>
        <h1>Vous êtes hors ligne</h1>
        <p>Vérifiez votre connexion internet et réessayez. Vos données seront synchronisées automatiquement.</p>
        <button class="btn" onclick="window.location.reload()">🔄 Réessayer</button>
        <div class="logo">EPG KANBAN · epg.ma</div>
    </div>
</body>
</html>
