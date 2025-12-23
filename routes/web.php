<?php

use App\Http\Controllers\Admin\AulaController;
use App\Http\Controllers\Admin\SemestreController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Alumno\FichaRegistroController;
use App\Http\Controllers\Alumno\FirmaTokenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta pública para registro de empresas
Route::get('/empresa/register', [\App\Http\Controllers\Empresa\EmpresaRegisterController::class, 'create'])
    ->name('empresa.register.form');
Route::post('/empresa/register', [\App\Http\Controllers\Empresa\EmpresaRegisterController::class, 'register'])
    ->name('empresa.register');

// Rutas de verificación de email
Route::get('/empresa/verify', [\App\Http\Controllers\Empresa\EmpresaRegisterController::class, 'showVerifyForm'])
    ->name('empresa.verify.form');
Route::post('/empresa/verify', [\App\Http\Controllers\Empresa\EmpresaRegisterController::class, 'verifyCode'])
    ->name('empresa.verify.code');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

        // Semestre
        Route::post('semestre/cerrar', [SemestreController::class, 'cerrar'])->name('semestre.cerrar');
        Route::post('semestre/nuevo', [SemestreController::class, 'store'])->name('semestre.nuevo');

        // Usuarios
        Route::resource('usuarios', UserController::class);

        // Aulas
        Route::resource('aulas', \App\Http\Controllers\Admin\AulaController::class);

        // Mostrar formulario para agregar alumnos
        Route::get('aulas/{aula}/agregar-alumnos', [AulaController::class, 'agregarAlumnos'])
            ->name('aulas.agregar-alumnos');

        // Guardar alumnos asignados
        Route::post('aulas/{aula}/asignar-alumnos', [AulaController::class, 'asignarAlumnos'])
            ->name('aulas.asignar-alumnos');

        Route::delete('aulas/{aula}/quitar-alumno/{alumno}', [AulaController::class, 'quitarAlumno'])
            ->name('aulas.quitar-alumno');

        // Aprobaciones de empresas
        Route::get('aprobaciones', [\App\Http\Controllers\Admin\AprobacionController::class, 'index'])
            ->name('aprobaciones.index');
        Route::post('aprobaciones/{id}/aprobar', [\App\Http\Controllers\Admin\AprobacionController::class, 'aprobar'])
            ->name('aprobaciones.aprobar');
        Route::delete('aprobaciones/{id}/rechazar', [\App\Http\Controllers\Admin\AprobacionController::class, 'rechazar'])
            ->name('aprobaciones.rechazar');

        // Perfiles - Ver detalles
        Route::get('perfil/empresa/{id}', [\App\Http\Controllers\Admin\PerfilController::class, 'empresa'])
            ->name('perfil.empresa');

        Route::get('perfil/solicitud/{id}', [\App\Http\Controllers\Admin\PerfilController::class, 'solicitudEmpresa'])
            ->name('perfil.solicitud');

    });


// Rutas del profesor
Route::middleware(['auth', 'rol:profesor'])
    ->prefix('profesor')
    ->as('profesor.')
    ->group(function () {

        // Entregas
        Route::get('entregas', [\App\Http\Controllers\Profesor\EntregaController::class, 'index'])
            ->name('entregas.index');
        Route::get('entregas/crear', [\App\Http\Controllers\Profesor\EntregaController::class, 'create'])
            ->name('entregas.create');
        Route::post('entregas', [\App\Http\Controllers\Profesor\EntregaController::class, 'store'])
            ->name('entregas.store');
    });

// Rutas de la empresa
Route::middleware(['auth', 'rol:empresa'])
    ->prefix('empresa')
    ->as('empresa.')
    ->group(function () {

        // Publicaciones
        Route::resource('publicaciones', \App\Http\Controllers\Empresa\PublicacionController::class);
    });


// Rutas del alumno
Route::middleware(['auth', 'rol:alumno'])
    ->prefix('alumno')
    ->as('alumno.')
    ->group(function () {

        // Listar prácticas disponibles
        Route::get('practicas', [\App\Http\Controllers\Alumno\VerPracticaController::class, 'index'])
            ->name('practicas.index');

        // Ver detalle de práctica
        Route::get('practicas/{id}', [\App\Http\Controllers\Alumno\VerPracticaController::class, 'show'])
            ->name('practicas.show');


        // Ficha Registro
        // Listado
        Route::get('fichas', [FichaRegistroController::class, 'index'])
            ->name('ficha.index');

        // Verificación de código
        Route::get('fichas/verificar-codigo', [FichaRegistroController::class, 'formVerificarCodigo'])
            ->name('ficha.codigo');

        Route::post('fichas/verificar-codigo', [FichaRegistroController::class, 'verificarCodigo'])
            ->name('ficha.codigo.verificar');

        // Crear ficha (PROTEGIDO)
        Route::get('fichas/create', [FichaRegistroController::class, 'create'])
            ->middleware('verificar.codigo.ficha')
            ->name('ficha.create');

        Route::post('fichas/store', [FichaRegistroController::class, 'store'])->name('ficha-registro.store');


    });

Route::get('/firmar/{token}', [FirmaTokenController::class, 'show'])
    ->name('firmas.show');

Route::post('/firmar/{token}', [FirmaTokenController::class, 'store'])
    ->name('firmas.store');


require __DIR__.'/auth.php';
