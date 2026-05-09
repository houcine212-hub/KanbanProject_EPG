<!DOCTYPE html>
<html lang="fr" dir="ltr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mon profil — EPG Kanban</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @include('profile.assets.styles')
</head>
<body>

@include('profile.layout.profile-layout')

@include('profile.assets.scripts')

</body>
</html>
