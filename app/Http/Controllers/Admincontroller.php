<?php

namespace App\Http\Controllers;

use App\Models\KanbanColumn;
use App\Models\KanbanTask;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
{
    abort_unless(auth()->user()->isAdmin(), 403);

    $usersCount        = User::where('role', 'user')->count();
    $totalTasks        = KanbanTask::count();
    $highPriorityTasks = KanbanTask::where('priority', 'high')->count();

    $users = User::where('role', 'user')
        ->withCount('tasks')
        ->orderByDesc('tasks_count')
        ->get();;

    $columns = KanbanColumn::withCount('tasks')
        ->orderBy('position')
        ->get();

    $recentTasks = KanbanTask::with(['user', 'column'])
        ->latest()
        ->paginate(20);

    return view('admin.dashboard', compact(
        'usersCount', 'totalTasks', 'highPriorityTasks',
        'users', 'columns', 'recentTasks'
    ));
}
}
