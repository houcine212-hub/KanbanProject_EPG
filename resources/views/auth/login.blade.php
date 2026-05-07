<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f1117;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            top: -150px;
            left: -150px;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            pointer-events: none;
        }

        .card {
            background: #13161f;
            border: 1px solid #1e2433;
            border-radius: 20px;
            padding: 2.5rem;
            width: 420px;
            max-width: 90vw;
            position: relative;
            z-index: 1;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo svg {
            width: 26px;
            height: 26px;
            fill: white;
        }

        .brand h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.02em;
        }

        .brand p {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 0.3rem;
        }

        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 0.4rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.7rem 1rem;
            background: #0f1117;
            border: 1px solid #1e2433;
            border-radius: 10px;
            color: #e2e8f0;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .input-wrap input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }

        .input-wrap input::placeholder {
            color: #334155;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
        }

        .remember-row label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.82rem;
            color: #64748b;
            cursor: pointer;
        }

        .remember-row input[type="checkbox"] {
            accent-color: #6366f1;
            width: 14px;
            height: 14px;
        }

        .btn-submit {
            width: 100%;
            padding: 0.78rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            font-family: inherit;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 1.4rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #1e2433;
        }

        .divider span {
            background: #13161f;
            padding: 0 0.75rem;
            font-size: 0.78rem;
            color: #475569;
            position: relative;
        }

        .link-row {
            text-align: center;
            font-size: 0.83rem;
            color: #64748b;
        }

        .link-row a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .link-row a:hover {
            text-decoration: underline;
        }

        .error-msg {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #f87171;
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            font-size: 0.82rem;
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <div class="brand-logo">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="3" width="7" height="11" rx="1.5"/>
                    <rect x="3" y="17" width="7" height="4" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="4" rx="1.5"/>
                    <rect x="14" y="10" width="7" height="11" rx="1.5"/>
                </svg>
            </div>
            <h1>Kanban Board</h1>
            <p>تسجيل الدخول إلى حسابك</p>
        </div>

        @if ($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <div class="input-wrap">
                    <input type="email" name="email" placeholder="example@email.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>كلمة المرور</label>
                <div class="input-wrap">
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    تذكرني
                </label>
            </div>

            <button type="submit" class="btn-submit">تسجيل الدخول</button>
        </form>

        <div class="divider"><span>أو</span></div>

        <div class="link-row">
            ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب</a>
        </div>
    </div>
</body>
</html>