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

// Rutas de Administrador
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

// Rutas de la empresa
Route::middleware(['auth', 'rol:empresa'])
    ->prefix('empresa')
    ->as('empresa.')
    ->group(function () {

        // Registro de empresa
        Route::post('register', [\App\Http\Controllers\Empresa\EmpresaRegisterController::class, 'register'])
            ->name('empresa.register');
        // Dashboard de empresa
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        // Publicaciones
        Route::resource('publicaciones', \App\Http\Controllers\Empresa\PublicacionController::class);
    });


// Rutas del alumno
Route::middleware(['auth', 'rol:alumno'])
    ->prefix('alumno')
    ->as('alumno.')
    ->group(function () {

        // Dashboard de alumno
        Route::get('/', function () {
            return view('dashboard');
        });

        // Listar prácticas disponibles
        Route::get('practicas', [\App\Http\Controllers\Alumno\VerPracticaController::class, 'index'])
            ->name('practicas.index');

        // Ver detalle de práctica
        Route::get('practicas/{id}', [\App\Http\Controllers\Alumno\VerPracticaController::class, 'show'])
            ->name('practicas.show');

        // Ficha de registro
        Route::resource('ficha-registro', \App\Http\Controllers\Alumno\FichaController::class);
    });

require __DIR__.'/auth.php';
