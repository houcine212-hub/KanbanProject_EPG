<?php

// ─────────────────────────────────────────────────────────────────────────────
// ADD THESE ROUTES TO YOUR routes/web.php
// ─────────────────────────────────────────────────────────────────────────────

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Kanban (auth required)
Route::middleware('auth')->group(function () {

    Route::get('/kanban', [KanbanController::class, 'index'])->name('kanban.index');
    Route::post('/kanban/tasks',              [KanbanController::class, 'storeTask'])->name('kanban.tasks.store');
    Route::patch('/kanban/tasks/{task}',      [KanbanController::class, 'updateTask'])->name('kanban.tasks.update');
    Route::delete('/kanban/tasks/{task}',     [KanbanController::class, 'destroyTask'])->name('kanban.tasks.destroy');
    Route::post('/kanban/tasks/reorder',      [KanbanController::class, 'reorderTasks'])->name('kanban.tasks.reorder');

    Route::post('/kanban/columns',            [KanbanController::class, 'storeColumn'])->name('kanban.columns.store');
    Route::delete('/kanban/columns/{column}', [KanbanController::class, 'destroyColumn'])->name('kanban.columns.destroy');
    Route::post('/kanban/columns/reorder',    [KanbanController::class, 'reorderColumns'])->name('kanban.columns.reorder');

    // Admin dashboard
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

    // Profile
    Route::get('/profile',                    [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile',                  [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password',         [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::patch('/profile/avatar',           [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    //chat bot ai
    Route::post('/chat/ask', [ChatController::class, 'ask'])->name('chat.ask')->middleware('auth');});
    Route::get('/chat-test', function() {return response()->json(['status' => 'ok','route_exists' => true,'csrf_token' => csrf_token(),]);});
    Route::redirect('/', '/kanban');
