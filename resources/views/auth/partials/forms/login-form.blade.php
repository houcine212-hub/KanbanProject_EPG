<form action="{{ route('login') }}" method="POST">
    @csrf
    
    @include('auth.partials.inputs.form-input', [
        'label' => 'البريد الإلكتروني',
        'type' => 'email',
        'name' => 'email',
        'placeholder' => 'example@epg.ma',
        'required' => true,
        'autofocus' => true
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'كلمة المرور',
        'type' => 'password',
        'name' => 'password',
        'placeholder' => '••••••••',
        'required' => true
    ])

    <div class="remember-row">
        <label>
            <input type="checkbox" name="remember">
            تذكرني
        </label>
    </div>

    <button type="submit" class="btn-submit">تسجيل الدخول</button>
</form>

<style>
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
        color: #6b7f96;
        cursor: pointer;
    }

    .remember-row input[type="checkbox"] {
        accent-color: #0055b3;
        width: 14px;
        height: 14px;
    }
</style>