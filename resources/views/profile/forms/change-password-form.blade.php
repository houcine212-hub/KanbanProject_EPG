<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-title">Change Password</div>
        <div class="form-card-sub">Use a strong password of at least 8 characters</div>
    </div>
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-card-body">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required id="newPassword" oninput="checkStrength(this.value)">
                <div class="pwd-strength">
                    <div class="pwd-bar" id="bar1"></div>
                    <div class="pwd-bar" id="bar2"></div>
                    <div class="pwd-bar" id="bar3"></div>
                    <div class="pwd-bar" id="bar4"></div>
                </div>
                <div class="form-hint" id="strengthLabel"></div>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password" required>
            </div>
        </div>
        <div class="form-card-footer">
            <span class="form-hint">You'll stay logged in after changing</span>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
    </form>
</div>