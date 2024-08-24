<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Route to display the home page with task management
Route::get('/', [TaskController::class, 'index'])->name('home');

// Route to handle task creation
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Route to handle task updating
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

// Route to handle task deletion
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
