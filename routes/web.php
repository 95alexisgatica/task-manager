<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskImageController;

// Página inicial - Sin autenticación requerida
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard - Requiere autenticación
Route::get('/dashboard', function () {
    return redirect()->route('tasks.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Categorías
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    // Tareas
    Route::resource('tasks', TaskController::class)->except(['edit', 'create', 'show']);

    // Imágenes de tareas
    Route::post('/tasks/{task}/images', [TaskImageController::class, 'store'])->name('task-images.store');
    Route::patch('/images/{image}/cover', [TaskImageController::class, 'setCover'])->name('task-images.cover');
    Route::delete('/images/{image}', [TaskImageController::class, 'destroy'])->name('task-images.destroy');
});

// Rutas de autenticación de Breeze
require __DIR__ . '/auth.php';
