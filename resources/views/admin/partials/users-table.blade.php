<div class="table-card" id="users">
    <div class="table-card-header">
        <span class="table-card-title">Users</span>
        @include('admin.components.badge', ['type' => 'blue', 'text' => $usersCount . ' total'])
    </div>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Tasks</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
                <tr>
                    <td>
                        <div class="user-cell">
                            @include('admin.components.user-avatar', [
                                'user' => $u,
                                'size' => 34,
                                'fontSize' => '0.68rem'
                            ])
                            <div class="user-cell-info">
                                <div class="name">{{ $u->name }}</div>
                                <div class="email">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @include('admin.components.badge', ['type' => 'blue', 'text' => $u->tasks_count])
                    </td>
                    <td style="min-width: 100px">
                        @php
                            $pct = $totalTasks > 0 ? round(($u->tasks_count / $totalTasks) * 100) : 0;
                        @endphp
                        @include('admin.components.progress-bar', ['percentage' => $pct])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="empty-state">No users yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>