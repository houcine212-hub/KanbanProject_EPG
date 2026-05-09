<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Utilisateurs</div>
        <div class="stat-value">{{ $usersCount }}</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Tâches</div>
        <div class="stat-value">{{ $totalTasks }}</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-label">Priorité haute</div>
        <div class="stat-value">{{ $highPriorityTasks }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Colonnes</div>
        <div class="stat-value">{{ $columns->count() }}</div>
    </div>
</div>
