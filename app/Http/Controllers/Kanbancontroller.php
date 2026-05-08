<?php

namespace App\Http\Controllers;

use App\Models\KanbanColumn;
use App\Models\KanbanTask;
use App\Models\User;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $users = collect();
        $selectedUser = null;
        $selectedUserId = null;
        $adminTasksCount = 0;

        if ($isAdmin) {
            $users = User::where('role', 'user')
                ->withCount('tasks')
                ->orderBy('name')
                ->get();

            $adminTasksCount = KanbanTask::where('user_id', $user->id)->count();
            $selectedUserId = $request->query('user_id');
            $selectedUser = $selectedUserId ? User::find($selectedUserId) : null;
        }

        $viewMine = $request->query('view') === 'mine';

        $columns = KanbanColumn::with(['tasks' => function ($query) use ($user, $isAdmin, $selectedUserId, $viewMine) {
            if ($isAdmin && $viewMine) {
                $query->where('user_id', $user->id);
            } elseif ($isAdmin && $selectedUserId) {
                $query->where('user_id', $selectedUserId);
            } elseif (!$isAdmin) {
                $query->where('user_id', $user->id);
            }
            $query->with('user')->orderBy('position');
        }])->orderBy('position')->get();

        return view('kanban.index', compact('columns', 'isAdmin', 'users', 'selectedUser', 'selectedUserId', 'adminTasksCount'));
    }

    public function storeColumn(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $data['position'] = KanbanColumn::max('position') + 1;
        KanbanColumn::create($data);

        return back();
    }

    public function destroyColumn(KanbanColumn $column)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $column->delete();
        return back();
    }

    public function storeTask(Request $request)
    {
        $data = $request->validate([
            'kanban_column_id' => 'required|exists:kanban_columns,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $data['user_id'] = auth()->id();
        $data['position'] = KanbanTask::where('kanban_column_id', $data['kanban_column_id'])->max('position') + 1;
        KanbanTask::create($data);

        return back();
    }

    public function updateTask(Request $request, KanbanTask $task)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task->update($data);
        return back();
    }

    public function destroyTask(KanbanTask $task)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $task->user_id !== $user->id) {
            abort(403);
        }

        $task->delete();
        return back();
    }

    public function reorderTasks(Request $request)
    {
        $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:kanban_tasks,id',
            'tasks.*.column_id' => 'required|exists:kanban_columns,id',
            'tasks.*.position' => 'required|integer',
        ]);

        $user = auth()->user();

        foreach ($request->tasks as $item) {
            $task = KanbanTask::find($item['id']);

            if (!$user->isAdmin() && $task->user_id !== $user->id) {
                continue;
            }

            $task->update([
                'kanban_column_id' => $item['column_id'],
                'position' => $item['position'],
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function reorderColumns(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $request->validate([
            'columns' => 'required|array',
            'columns.*.id' => 'required|exists:kanban_columns,id',
            'columns.*.position' => 'required|integer',
        ]);

        foreach ($request->columns as $item) {
            KanbanColumn::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}