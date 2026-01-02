<?php

use App\Http\Controllers\Admin\AulaController;
use App\Http\Controllers\Admin\SemestreController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Alumno\CronogramaController;
use App\Http\Controllers\Alumno\FichaRegistroController;
use App\Http\Controllers\Alumno\FirmaCronogramaController;
use App\Http\Controllers\Alumno\FirmaTokenController;
use App\Http\Controllers\Profesor\EntregaController;
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

        // Informes Finales
        Route::get('informes-finales', [\App\Http\Controllers\Admin\InformeFinalController::class, 'index'])
            ->name('informes-finales.index');
        Route::get('informes-finales/{informe}/download', [\App\Http\Controllers\Admin\InformeFinalController::class, 'download'])
            ->name('informes-finales.download');
        Route::delete('informes-finales/{informe}', [\App\Http\Controllers\Admin\InformeFinalController::class, 'destroy'])
            ->name('informes-finales.destroy');

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
        Route::post(
            'profesor/entregas/{entrega}/calificar/{alumno}',
            [EntregaController::class, 'calificar']
        )->name('entregas.calificar');

        // Ver entrega de un alumno
        Route::get(
            'profesor/entregas/{entrega}/alumno/{alumno}',
            [EntregaController::class, 'verEntregaAlumno']
        )->name('entregas.ver-alumno');

        // Guardar calificación
        Route::post(
            'profesor/entregas/{entrega}/alumno/{alumno}/calificar',
            [EntregaController::class, 'guardarCalificacion']
        )->name('entregas.guardar-calificacion');


        // Aulas del profesor
        Route::get('aulas', [\App\Http\Controllers\Profesor\AulaController::class, 'index'])
            ->name('aulas.index');

        Route::get('aulas/{aula}', [\App\Http\Controllers\Profesor\AulaController::class, 'show'])
            ->name('aulas.show');


        // routes/web.php (grupo profesor)

        Route::get('entregas/{entrega}',
            [\App\Http\Controllers\Profesor\EntregaController::class, 'show']
        )->name('entregas.show');


        // Fichas de registro (profesor)
        Route::get('fichas/{fichaRegistro}',
            [\App\Http\Controllers\Profesor\FichaRegistroController::class, 'show']
        )->name('fichas.show');

        Route::patch('fichas/{fichaRegistro}/aceptar',
            [\App\Http\Controllers\Profesor\FichaRegistroController::class, 'aceptar']
        )->name('fichas.aceptar');

        // Cronogramas (profesor)
        Route::get(
            'cronogramas/{cronograma}',
            [\App\Http\Controllers\Profesor\CronogramaController::class, 'show']
        )->name('cronogramas.show');

        Route::post(
            'cronogramas/{cronograma}/firmar',
            [\App\Http\Controllers\Profesor\CronogramaController::class, 'firmar']
        )->name('cronogramas.firmar');

        // Informes Finales
        Route::get('informes-finales', [\App\Http\Controllers\Profesor\InformeFinalController::class, 'index'])
            ->name('informes-finales.index');
        Route::get('informes-finales/{informe}/download', [\App\Http\Controllers\Profesor\InformeFinalController::class, 'download'])
            ->name('informes-finales.download');

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


        // Crear ficha (PROTEGIDO)
        Route::get('fichas/create', [FichaRegistroController::class, 'create'])
            ->name('ficha.create');

        Route::post('fichas/store', [FichaRegistroController::class, 'store'])->name('ficha-registro.store');

        Route::get('fichas/{fichaRegistro}',
            [FichaRegistroController::class, 'show']
        )->name('ficha.show');

        // Cronograma
        Route::get('cronograma/create/{fichaRegistro}',
            [CronogramaController::class, 'create']
        )->name('cronograma.create');

        Route::post('cronograma/{fichaRegistro}',
            [CronogramaController::class, 'store']
        )->name('cronograma.store');

        Route::get('cronograma/{cronograma}',
            [CronogramaController::class, 'show']
        )->name('cronograma.show');


        // Mis entregas y calificaciones
        Route::get('mis-entregas', [\App\Http\Controllers\Alumno\MisEntregasController::class, 'index'])
            ->name('entregas.mis-entregas');
        Route::get('mis-entregas/{entrega}', [\App\Http\Controllers\Alumno\MisEntregasController::class, 'show'])
            ->name('entregas.detalle');
        Route::post('mis-entregas/{entrega}/guardar-link', [\App\Http\Controllers\Alumno\MisEntregasController::class, 'guardarLink'])
            ->name('entregas.guardar-link');

        // Informe Final
        Route::get('informe-final', [\App\Http\Controllers\Alumno\InformeFinalController::class, 'index'])
            ->name('informe-final.index');
        Route::post('informe-final', [\App\Http\Controllers\Alumno\InformeFinalController::class, 'store'])
            ->name('informe-final.store');
        Route::get('informe-final/download', [\App\Http\Controllers\Alumno\InformeFinalController::class, 'download'])
            ->name('informe-final.download');
    });

Route::get('/firmar/{token}', [FirmaTokenController::class, 'show'])
    ->name('firmas.show');

Route::post('/firmar/{token}', [FirmaTokenController::class, 'store'])
    ->name('firmas.store');


// Mostrar formulario de firma
Route::get(
    'firmas/cronograma/jefe/{token}',
    [FirmaCronogramaController::class, 'formJefe']
)->name('firma.cronograma.jefe');

// Guardar firma
Route::post(
    'firmas/cronograma/jefe/{token}',
    [FirmaCronogramaController::class, 'guardarFirmaJefe']
)->name('firma.cronograma.jefe.guardar');
require __DIR__.'/auth.php';
