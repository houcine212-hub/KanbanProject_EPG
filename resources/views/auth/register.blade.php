<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPG — إنشاء حساب</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4f9;
            min-height: 100vh;
            display: flex;
        }

        .left-panel {
            width: 420px;
            min-width: 420px;
            background: linear-gradient(160deg, #003d8f 0%, #0055b3 50%, #0a6fd4 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            top: -200px;
            right: -150px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        .left-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .left-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
            margin-bottom: 1.75rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .left-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.02em;
            margin-bottom: 0.6rem;
        }

        .left-sub {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            max-width: 260px;
            margin: 0 auto;
        }

        .left-divider {
            width: 40px;
            height: 2px;
            background: rgba(255,255,255,0.25);
            margin: 1.5rem auto;
            border-radius: 2px;
        }

        .steps {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            text-align: left;
            max-width: 240px;
            margin: 0 auto;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            color: white;
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.7);
        }

        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-card {
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0d1b2e;
            letter-spacing: -0.02em;
        }

        .form-header p {
            font-size: 0.875rem;
            color: #6b7f96;
            margin-top: 0.35rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #4a5e78;
            margin-bottom: 0.4rem;
            letter-spacing: 0.01em;
        }

        .form-group input {
            width: 100%;
            padding: 0.7rem 1rem;
            background: white;
            border: 1.5px solid #dde3ed;
            border-radius: 10px;
            color: #0d1b2e;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .form-group input:focus {
            border-color: #0055b3;
            box-shadow: 0 0 0 3px rgba(0,85,179,0.08);
        }

        .form-group input::placeholder {
            color: #b0bdcc;
        }

        .hint {
            font-size: 0.75rem;
            color: #8fa3bc;
            margin-top: 0.3rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.8rem;
            background: #0055b3;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            font-family: inherit;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background: #003d8f;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0,85,179,0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .link-row {
            text-align: center;
            font-size: 0.85rem;
            color: #6b7f96;
            margin-top: 1.4rem;
        }

        .link-row a {
            color: #0055b3;
            text-decoration: none;
            font-weight: 600;
        }

        .link-row a:hover { text-decoration: underline; }

        .error-msg {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 0.65rem 0.9rem;
            border-radius: 9px;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="left-content">
            <img src="{{ asset('images/epg-logo.jpg') }}" alt="EPG" class="left-logo">
            <div class="left-title">إنضم إلى EPG</div>
            <div class="left-sub">أنشئ حسابك وابدأ إدارة مهامك بكل سهولة</div>
            <div class="left-divider"></div>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">أنشئ حسابك</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">أضف مهامك</div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">تابع التقدم</div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="form-card">
            <div class="form-header">
                <h2>إنشاء حساب جديد</h2>
                <p>أدخل بياناتك للتسجيل</p>
            </div>

            @if ($errors->any())
                <div class="error-msg">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>الاسم الكامل</label>
                    <input type="text" name="name" placeholder="أدخل اسمك الكامل" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" placeholder="example@epg.ma" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                    <p class="hint">8 أحرف على الأقل</p>
                </div>

                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit">إنشاء الحساب</button>
            </form>

            <div class="link-row">
                لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
            </div>
        </div>
    </div>
</body>
</html>