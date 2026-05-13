<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskImageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    Route::resource('tasks', TaskController::class)->except(['edit', 'create', 'show']);

    Route::post('/tasks/{task}/images', [TaskImageController::class, 'store'])->name('task-images.store');
    Route::patch('/images/{image}/cover', [TaskImageController::class, 'setCover'])->name('task-images.cover');
    Route::delete('/images/{image}', [TaskImageController::class, 'destroy'])->name('task-images.destroy');
});

require __DIR__ . '/auth.php';
