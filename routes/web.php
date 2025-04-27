<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace.index');
    Route::get('/workspace/create', [WorkspaceController::class, 'create'])->name('workspace.create');
    Route::post('/workspace', [WorkspaceController::class, 'store'])->name('workspace.store');
    Route::get('/workspace/{workspace}', [WorkspaceController::class, 'show'])->name('workspace.show');

    Route::prefix('workspace/{workspace}')->group(function() {
        Route::get('/task', [TaskController::class, 'index'])->name('task.index');
        Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
        Route::post('/task', [TaskController::class, 'store'])->name('task.store');
        Route::patch('/task/{task}', [TaskController::class, 'update'])->name('task.update');
        Route::get('/task/{task}', [TaskController::class, 'show'])->name('task.show');
    });
});

require __DIR__.'/auth.php';
