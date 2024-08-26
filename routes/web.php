<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Route to display all tasks and the form to create a new task
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

// Route to create a new task
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Route to update a specific task
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

// Route to delete a specific task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Route to show a specific task (if needed)
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
