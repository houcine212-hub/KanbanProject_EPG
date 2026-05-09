<div class="profile-stats">
    <div class="pstat">
        <div class="pstat-val">{{ auth()->user()->tasks()->count() }}</div>
        <div class="pstat-lbl">Tâches</div>
    </div>
    <div class="pstat">
        <div class="pstat-val">{{ auth()->user()->tasks()->where('priority','high')->count() }}</div>
        <div class="pstat-lbl">Priorité haute</div>
    </div>
    <div class="pstat" style="grid-column: span 2">
        <div class="pstat-val" style="font-size:0.9rem">{{ auth()->user()->created_at->format('M Y') }}</div>
        <div class="pstat-lbl">Membre depuis</div>
    </div>
</div>
