<?php

use App\Http\Controllers\KanbanController;
use Illuminate\Support\Facades\Route;

Route::prefix('kanban')->name('kanban.')->group(function () {
    Route::get('/', [KanbanController::class, 'index'])->name('index');

    Route::post('/columns', [KanbanController::class, 'storeColumn'])->name('columns.store');
    Route::delete('/columns/{column}', [KanbanController::class, 'destroyColumn'])->name('columns.destroy');

    Route::post('/tasks', [KanbanController::class, 'storeTask'])->name('tasks.store');
    Route::delete('/tasks/{task}', [KanbanController::class, 'destroyTask'])->name('tasks.destroy');

    Route::post('/tasks/reorder', [KanbanController::class, 'reorderTasks'])->name('tasks.reorder');
    Route::post('/columns/reorder', [KanbanController::class, 'reorderColumns'])->name('columns.reorder');
});