<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @include('auth.partials.styles.auth-styles')
    @yield('extra-styles')
</head>
<body>
    <div class="auth-container" id="authContainer">
        <!-- دوائر خلفية -->
        <div class="bg-circle bg-circle-1"></div>
        <div class="bg-circle bg-circle-2"></div>
        <div class="bg-circle bg-circle-3"></div>

        <!-- المحتوى المركزي (الشعار + الأزرار) -->
        @include('auth.partials.shared.hero')

        <!-- اللوحة الجانبية -->
        <div class="left-sidebar" id="leftSidebar">
            @yield('left-panel-content')
        </div>

        <!-- حاوية النموذج -->
        <div class="form-panel" id="formPanel">
            <div class="form-card" id="formCard">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- النماذج المخبية باش JS يستعملهم -->
    <div id="loginFormContainer" style="display: none;">
        @include('auth.partials.forms.login-form')
    </div>
    <div id="registerFormContainer" style="display: none;">
        @include('auth.partials.forms.register-form')
    </div>

    @include('auth.partials.scripts.auth-scripts')
</body>
</html>