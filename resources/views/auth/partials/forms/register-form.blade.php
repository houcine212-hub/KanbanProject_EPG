<form action="{{ route('register') }}" method="POST">
    @csrf
    
    @include('auth.partials.inputs.form-input', [
        'label' => 'الاسم الكامل',
        'type' => 'text',
        'name' => 'name',
        'placeholder' => 'أدخل اسمك الكامل',
        'required' => true,
        'autofocus' => true
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'البريد الإلكتروني',
        'type' => 'email',
        'name' => 'email',
        'placeholder' => 'example@epg.ma',
        'required' => true
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'كلمة المرور',
        'type' => 'password',
        'name' => 'password',
        'placeholder' => '••••••••',
        'required' => true,
        'hint' => '8 أحرف على الأقل'
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'تأكيد كلمة المرور',
        'type' => 'password',
        'name' => 'password_confirmation',
        'placeholder' => '••••••••',
        'required' => true
    ])

    <button type="submit" class="btn-submit">إنشاء الحساب</button>
</form>