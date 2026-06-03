<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes — TaskFlow
|--------------------------------------------------------------------------
|
| Semua route web aplikasi TaskFlow didefinisikan di sini.
| Route resource tasks mencakup: index, create, store, edit, update, destroy.
|
*/

// Redirect root ke halaman daftar tugas
Route::get('/', function () {
    return redirect('/tasks');
});

// Halaman utama
Route::get('/dashboard',  [TaskController::class, 'dashboard']);
Route::get('/deadline',   [TaskController::class, 'deadline']);
Route::get('/statistics', [TaskController::class, 'statistics']);

// Pengaturan pengguna
Route::get('/settings',       [TaskController::class, 'settings']);
Route::post('/settings/save', [TaskController::class, 'saveSettings']);

// Toggle status selesai pada tugas
Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleDone'])->name('tasks.toggle');

// CRUD tugas (index, create, store, show, edit, update, destroy)
Route::resource('tasks', TaskController::class);
