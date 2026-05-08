<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-title">Personal Information</div>
        <div class="form-card-sub">Update your name and email address</div>
    </div>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-card-body">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
            </div>
        </div>
        <div class="form-card-footer">
            <span class="form-hint">Changes apply immediately</span>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>