<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('partials.pwa-head')

    @include('auth.partials.styles.auth-styles')
    @yield('extra-styles')
</head>
<body>
    <div class="auth-container" id="authContainer">
        <div class="bg-circle bg-circle-1"></div>
        <div class="bg-circle bg-circle-2"></div>
        <div class="bg-circle bg-circle-3"></div>

        @include('auth.partials.shared.hero')

        <div class="left-sidebar" id="leftSidebar">
            @yield('left-panel-content')
        </div>

        <div class="form-panel" id="formPanel">
            <div class="form-card" id="formCard">
                @yield('content')
            </div>
        </div>
    </div>

    <div id="loginFormContainer" style="display: none;">
        @include('auth.partials.forms.login-form')
    </div>
    <div id="registerFormContainer" style="display: none;">
        @include('auth.partials.forms.register-form')
    </div>

    @include('auth.partials.scripts.auth-scripts')
</body>
</html>
