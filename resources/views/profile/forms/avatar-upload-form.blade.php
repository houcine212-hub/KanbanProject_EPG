<form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
    @csrf @method('PATCH')
    <input type="file" id="avatarInput" name="avatar" accept="image/*" onchange="previewAvatar(this)">
</form>