<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

Route::middleware(['auth', 'rol:administrador'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // Dashboard de admin
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        // Usuarios
        Route::resource('usuarios', UserController::class);

    });


require __DIR__.'/auth.php';
