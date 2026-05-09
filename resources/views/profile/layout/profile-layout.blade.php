@include('profile.layout.sidebar')

<div class="main">
    @include('profile.layout.topbar')

    <div class="content">
        <div class="profile-layout">

            @include('profile.components.avatar-card')

            <div class="forms-col">

                @include('profile.partials.alerts')
                @include('profile.forms.avatar-upload-form')
                @include('profile.forms.update-info-form')
                @include('profile.forms.change-password-form')

            </div>
        </div>
    </div>
</div>
