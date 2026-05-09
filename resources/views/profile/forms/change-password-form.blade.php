<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-title">Changer le mot de passe</div>
        <div class="form-card-sub">Utilisez un mot de passe fort d'au moins 8 caractères</div>
    </div>
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-card-body">
            <div class="form-group">
                <label>Mot de passe actuel</label>
                <input type="password" name="current_password" class="form-control" placeholder="Entrez le mot de passe actuel" required>
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 caractères" required id="newPassword" oninput="checkStrength(this.value)">
                <div class="pwd-strength">
                    <div class="pwd-bar" id="bar1"></div>
                    <div class="pwd-bar" id="bar2"></div>
                    <div class="pwd-bar" id="bar3"></div>
                    <div class="pwd-bar" id="bar4"></div>
                </div>
                <div class="form-hint" id="strengthLabel"></div>
            </div>
            <div class="form-group">
                <label>Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Répétez le nouveau mot de passe" required>
            </div>
        </div>
        <div class="form-card-footer">
            <span class="form-hint">Vous resterez connecté après la modification</span>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>
