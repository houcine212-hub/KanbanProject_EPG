<div class="profile-card">
    <div class="profile-cover">
        <div class="profile-cover-pattern"></div>
    </div>
    <div class="profile-ava-wrap">
        <div class="profile-ava-ring" onclick="document.getElementById('avatarInput').click()">
            @if(auth()->user()->avatar)
                <img id="avatarPreview" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
            @else
                <span id="avatarInitial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <img id="avatarPreview" src="" alt="" style="display:none">
            @endif
            <div class="profile-ava-overlay">Edit</div>
        </div>
        <div class="profile-ava-hint">Click to change photo</div>

        <div class="profile-display-name">{{ auth()->user()->name }}</div>
        <div class="profile-display-email">{{ auth()->user()->email }}</div>
        <span class="profile-role-badge {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-user' }}">
            {{ auth()->user()->isAdmin() ? 'Admin' : 'Member' }}
        </span>
    </div>

    @include('profile.components.profile-stats')

    <div style="height: 1.25rem"></div>
</div>