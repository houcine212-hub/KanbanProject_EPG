<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-title">Informations personnelles</div>
        <div class="form-card-sub">Mettez à jour votre nom et votre adresse e-mail</div>
    </div>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-card-body">
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            </div>
            <div class="form-group">
                <label>Adresse e-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
            </div>
        </div>
        <div class="form-card-footer">
            <span class="form-hint">Les modifications s'appliquent immédiatement</span>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
