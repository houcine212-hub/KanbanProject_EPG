<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Users</div>
        <div class="stat-value">{{ $usersCount }}</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Total Tasks</div>
        <div class="stat-value">{{ $totalTasks }}</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-label">High Priority</div>
        <div class="stat-value">{{ $highPriorityTasks }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Board Columns</div>
        <div class="stat-value">{{ $columns->count() }}</div>
    </div>
</div>