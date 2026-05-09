<form action="{{ route('register') }}" method="POST">
    @csrf

    @include('auth.partials.inputs.form-input', [
        'label' => 'Nom complet',
        'type' => 'text',
        'name' => 'name',
        'placeholder' => 'Entrez votre nom complet',
        'required' => true,
        'autofocus' => true
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'Adresse e-mail',
        'type' => 'email',
        'name' => 'email',
        'placeholder' => 'exemple@epg.ma',
        'required' => true
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'Mot de passe',
        'type' => 'password',
        'name' => 'password',
        'placeholder' => '••••••••',
        'required' => true,
        'hint' => 'Au moins 8 caractères'
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'Confirmer le mot de passe',
        'type' => 'password',
        'name' => 'password_confirmation',
        'placeholder' => '••••••••',
        'required' => true
    ])

    <button type="submit" class="btn-submit">Créer le compte</button>
</form>
