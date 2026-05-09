<form action="{{ route('login') }}" method="POST">
    @csrf

    @include('auth.partials.inputs.form-input', [
        'label' => 'Adresse e-mail',
        'type' => 'email',
        'name' => 'email',
        'placeholder' => 'exemple@epg.ma',
        'required' => true,
        'autofocus' => true
    ])

    @include('auth.partials.inputs.form-input', [
        'label' => 'Mot de passe',
        'type' => 'password',
        'name' => 'password',
        'placeholder' => '••••••••',
        'required' => true
    ])

    <div class="remember-row">
        <label>
            <input type="checkbox" name="remember">
            Se souvenir de moi
        </label>
    </div>

    <button type="submit" class="btn-submit">Se connecter</button>
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
