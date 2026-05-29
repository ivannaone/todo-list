<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect('/tasks');
});

Route::get('/dashboard',   [TaskController::class, 'dashboard']);
Route::get('/deadline',    [TaskController::class, 'deadline']);
Route::get('/statistics',  [TaskController::class, 'statistics']);
Route::get('/settings',    [TaskController::class, 'settings']);
Route::post('/settings/save', [TaskController::class, 'saveSettings']);

Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleDone'])->name('tasks.toggle');

Route::resource('tasks', TaskController::class);
