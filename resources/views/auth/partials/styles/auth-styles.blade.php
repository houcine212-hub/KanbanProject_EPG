<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f0f4f9;
        min-height: 100vh;
        display: flex;
        overflow: hidden;
    }

    /* ── الحالة الأولى: الصفحة الكاملة باللون الأزرق ── */
    .auth-container {
        position: relative;
        width: 100%;
        height: 100vh;
        display: flex;
        background: linear-gradient(160deg, #003d8f 0%, #0055b3 50%, #0a6fd4 100%);
        overflow: hidden;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* دوائر خلفية شفافة */
    .auth-container .bg-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        animation: gentle-float 8s ease-in-out infinite;
    }

    .auth-container .bg-circle-1 {
        width: 500px;
        height: 500px;
        top: -150px;
        right: -100px;
        animation-delay: 0s;
    }

    .auth-container .bg-circle-2 {
        width: 350px;
        height: 350px;
        bottom: -80px;
        left: -80px;
        background: rgba(255,255,255,0.03);
        animation-delay: -3s;
        animation-duration: 10s;
    }

    .auth-container .bg-circle-3 {
        width: 200px;
        height: 200px;
        top: 50%;
        left: 20%;
        background: rgba(255,255,255,0.025);
        animation-delay: -5s;
        animation-duration: 12s;
    }

    @keyframes gentle-float {
        0%, 100% { 
            transform: translateY(0) scale(1); 
            opacity: 0.6;
        }
        50% { 
            transform: translateY(-15px) scale(1.02); 
            opacity: 1;
        }
    }

    @keyframes logo-pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }

    /* ── المحتوى المركزي ── */
    .hero-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-logo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.3);
        margin-bottom: 1.5rem;
        animation: logo-pulse 3s ease-in-out infinite;
    }

    .hero-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .hero-sub {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.7);
        line-height: 1.5;
        max-width: 280px;
        text-align: center;
        margin-bottom: 2rem;
    }

    /* ── الأزرار العمودية ── */
    .hero-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.6s ease;
    }

    .btn-pill {
        width: 180px;
        height: 42px;
        border-radius: 21px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        border: 2px solid rgba(255,255,255,0.35);
        background: rgba(255,255,255,0.1);
        color: white;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        letter-spacing: 0.02em;
    }

    .btn-pill:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.6);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .btn-pill:active {
        transform: translateY(0) scale(0.98);
    }

    .btn-pill svg {
        width: 14px;
        height: 14px;
    }

    /* ── الحالة الثانية: نموذج تسجيل الدخول ── */
    .auth-container.active-login {
        background: #f0f4f9;
    }

    .auth-container.active-login .bg-circle {
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.6s ease;
    }

    .auth-container.active-login .hero-content {
        transform: translateY(-100vh);
        opacity: 0;
    }

    .auth-container.active-login .form-panel {
        transform: translateX(0);
        opacity: 1;
    }

    .auth-container.active-login .left-sidebar {
        transform: translateX(0);
    }

    /* ── اللوحة الجانبية الزرقاء ── */
    .left-sidebar {
        width: 380px;
        min-width: 380px;
        background: linear-gradient(160deg, #003d8f 0%, #0055b3 50%, #0a6fd4 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 2rem;
        position: relative;
        overflow: hidden;
        transform: translateX(-100%);
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .left-sidebar::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        top: -150px;
        right: -100px;
    }

    .left-sidebar::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
        bottom: -80px;
        left: -80px;
    }

    .left-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .left-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.3);
        margin-bottom: 1.5rem;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .left-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
    }

    .left-sub {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.65);
        line-height: 1.6;
        max-width: 240px;
        margin: 0 auto;
    }

    .left-divider {
        width: 35px;
        height: 2px;
        background: rgba(255,255,255,0.25);
        margin: 1.2rem auto;
        border-radius: 2px;
    }

    /* ── لوحة النموذج ── */
    .form-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        transform: translateX(100vw);
        opacity: 0;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card {
        width: 100%;
        max-width: 400px;
    }

    .form-header h2 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0d1b2e;
        letter-spacing: -0.02em;
    }

    .form-header p {
        font-size: 0.85rem;
        color: #6b7f96;
        margin-top: 0.3rem;
    }

    .btn-submit {
        width: 100%;
        padding: 0.75rem;
        background: #0055b3;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.88rem;
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

    .link-row {
        text-align: center;
        font-size: 0.82rem;
        color: #6b7f96;
        margin-top: 1.2rem;
    }

    .link-row a {
        color: #0055b3;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }

    .link-row a:hover { text-decoration: underline; }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: #6b7f96;
        font-size: 0.82rem;
        cursor: pointer;
        margin-bottom: 1rem;
        transition: color 0.2s;
        padding: 0.3rem;
        border-radius: 6px;
    }

    .back-btn:hover { 
        color: #0055b3; 
        background: rgba(0,85,179,0.05);
    }

    /* ── styles ديال النماذج (اللي كانو فالأسفل) ── */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: #4a5e78;
        margin-bottom: 0.35rem;
        letter-spacing: 0.01em;
    }

    .form-group input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        background: white;
        border: 1.5px solid #dde3ed;
        border-radius: 10px;
        color: #0d1b2e;
        font-size: 0.88rem;
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
        font-size: 0.72rem;
        color: #8fa3bc;
        margin-top: 0.25rem;
    }

    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.2rem;
    }

    .remember-row label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: #6b7f96;
        cursor: pointer;
    }

    .remember-row input[type="checkbox"] {
        accent-color: #0055b3;
        width: 14px;
        height: 14px;
    }

    .error-msg {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        color: #dc2626;
        padding: 0.6rem 0.85rem;
        border-radius: 9px;
        font-size: 0.8rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .left-sidebar { display: none; }
    }
</style>