<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard de tarefas (com dados das tarefas)
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

    // Minhas tarefas
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    // CRUD de tarefas
    Route::resource('tasks', TaskController::class)->except(['index']);
});

require __DIR__ . '/auth.php';
