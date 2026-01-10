<?php

use App\Http\Controllers\Admin\AulaController;
use App\Http\Controllers\Admin\SemestreController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Alumno\CronogramaController;
use App\Http\Controllers\Alumno\EntregaController;
use App\Http\Controllers\Alumno\FichaRegistroController;
use App\Http\Controllers\Alumno\FirmaCronogramaController;
use App\Http\Controllers\Alumno\FirmaTokenController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\Profesor\ActividadesController;
use App\Http\Controllers\Profesor\EntregasController;
use App\Http\Controllers\Profesor\SemanaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


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
        Route::resource('aulas', AulaController::class);

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

        // Si necesitas un índice general de todas las semanas (opcional)
        Route::get('semanas', [SemanaController::class, 'index'])->name('semanas.index');


        // Ruta para ver el aula
        Route::get('/aula/{aula}', [AulaController::class, 'index'])
            ->name('aula.index');

        // Aulas del profesor

        Route::get('aulas/{aula}', [\App\Http\Controllers\Profesor\AulaController::class, 'show'])
            ->name('aulas.show');


        // Rutas de Semanas
        Route::get('aulas/{aula}/semanas/create', [SemanaController::class, 'create'])->name('semanas.create');
        Route::post('aulas/{aula}/semanas', [SemanaController::class, 'store'])->name('semanas.store');
        Route::get('semanas/{semana}', [SemanaController::class, 'show'])->name('semanas.show');
        Route::get('semanas/{semana}/edit', [SemanaController::class, 'edit'])->name('semanas.edit');
        Route::put('semanas/{semana}', [SemanaController::class, 'update'])->name('semanas.update');
        Route::delete('semanas/{semana}', [SemanaController::class, 'destroy'])->name('semanas.destroy');

        // Actividades
        Route::get('/aulas/{aula}/actividades/create', [ActividadesController::class, 'create'])->name('actividades.create');
        Route::post('/aulas/{aula}/actividades', [ActividadesController::class, 'store'])->name('actividades.store');
        Route::get('/actividades/{actividad}', [ActividadesController::class, 'show'])->name('actividades.show');
        Route::delete('/actividades/{actividad}/destroy', [ActividadesController::class, 'destroy'])->name('actividades.destroy');

        // routes/web.php (grupo profesor)

        Route::patch('entregas/{entrega}/calificar', [EntregasController::class, 'calificar'])
            ->name('entregas.calificar');


        // Fichas de registro (profesor)
        Route::get('fichas/{fichaRegistro}',
            [\App\Http\Controllers\Profesor\FichaRegistroController::class, 'show']
        )->name('fichas.show');

        Route::patch('fichas/{fichaRegistro}/aceptar',
            [\App\Http\Controllers\Profesor\FichaRegistroController::class, 'aceptar']
        )->name('fichas.aceptar');

        Route::patch('fichas/{fichaRegistro}/rechazar',
            [\App\Http\Controllers\Profesor\FichaRegistroController::class, 'rechazar']
        )->name('fichas.rechazar');

        // Cronogramas (profesor)
        Route::get(
            'cronogramas/{cronograma}',
            [\App\Http\Controllers\Profesor\CronogramaController::class, 'show']
        )->name('cronogramas.show');

        Route::post(
            'cronogramas/{cronograma}/firmar',
            [\App\Http\Controllers\Profesor\CronogramaController::class, 'firmar']
        )->name('cronogramas.firmar');

        Route::patch('cronogramas/{cronograma}/calificar',
            [\App\Http\Controllers\Profesor\CronogramaController::class, 'calificar']
        )->name('cronogramas.calificar');

        // Monitoreo de Prácticas
        Route::get('monitoreos-practicas/alumno/{alumno}',
            [\App\Http\Controllers\Profesor\MonitoreoPracticaController::class, 'index']
        )->name('monitoreos-practicas.index');

        Route::get('monitoreos-practicas/{monitoreoPractica}',
            [\App\Http\Controllers\Profesor\MonitoreoPracticaController::class, 'show']
        )->name('monitoreos-practicas.show');

        // Informes Finales
        Route::get('informes-finales', [\App\Http\Controllers\Profesor\InformeFinalController::class, 'index'])
            ->name('informes-finales.index');
        Route::get('informes-finales/{informe}/download', [\App\Http\Controllers\Profesor\InformeFinalController::class, 'download'])
            ->name('informes-finales.download');

        // Formato 11

        // Ruta para listar todos los formatos once del profesor
        Route::get('/formato-once', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'index'])
            ->name('formato-once.index');

        // Ruta para crear un nuevo formato once para un aula específica
        Route::get('/formato-once/create/{aula}', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'create'])
            ->name('formato-once.create');

        // Ruta para guardar el nuevo formato once
        Route::post('/formato-once/store/{aula}', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'store'])
            ->name('formato-once.store');

        // Ruta para ver un formato once específico
        Route::get('/formato-once/{formatoOnce}', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'show'])
            ->name('formato-once.show');

        // Ruta para editar un formato once
        Route::get('/formato-once/{formatoOnce}/edit', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'edit'])
            ->name('formato-once.edit');

        Route::get('/formato-once/{formatoOnce}/destroy', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'destroy'])
            ->name('formato-once.destroy');

        Route::get('/aula/{aula}/list', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'list'])->name('formato-once.list');


        // Ruta para actualizar un formato once
        Route::put('/formato-once/list/{formatoOnce}', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'update'])
            ->name('formato-once.update');


        // Ruta para generar PDF del formato once
        Route::get('/formato-once/{formatoOnce}/pdf', [\App\Http\Controllers\Profesor\FormatoOnceController::class, 'generatePdf'])
            ->name('formato-once.pdf');

        // Formato 12

        Route::get('/formato-doce', [\App\Http\Controllers\Profesor\FormatoDoceController::class, 'index'])
            ->name('formato-doce.index');
        Route::get('/formato-doce/create', [\App\Http\Controllers\Profesor\FormatoDoceController::class, 'create'])
            ->name('formato-doce.create');
        Route::post('/formato-doce/store', [\App\Http\Controllers\Profesor\FormatoDoceController::class, 'store'])
            ->name('formato-doce.store');
        Route::get('/formato-doce/show', [\App\Http\Controllers\Profesor\FormatoDoceController::class, 'show'])
            ->name('formato-doce.show');
        Route::get(
            'formato-doce/aula/{aula}/alumnos',
            [\App\Http\Controllers\Profesor\FormatoDoceController::class, 'getAlumnos']
        )->name('formato-doce.alumnos');

        Route::delete('/formato-doce/{id}/destroy', [\App\Http\Controllers\Profesor\FormatoDoceController::class, 'destroy'])
            ->name('formato-doce.destroy');
    });

// Rutas de la empresa
Route::middleware(['auth', 'rol:empresa'])
    ->prefix('empresa')
    ->as('empresa.')
    ->group(function () {

        // Publicaciones
        Route::resource('publicaciones', \App\Http\Controllers\Empresa\PublicacionController::class);
        // Postulaciones
        Route::get('postulaciones', [\App\Http\Controllers\Empresa\PostulacionController::class, 'index'])
        ->name('postulaciones.index');
        Route::get('postulaciones/{publicacion}', [\App\Http\Controllers\Empresa\PostulacionController::class, 'show'])
            ->name('postulaciones.show');
        Route::patch('postulaciones/{postulacion}/aprobar', [\App\Http\Controllers\Empresa\PostulacionController::class, 'aprobar'])
            ->name('postulaciones.aprobar');

        Route::patch('postulaciones/{postulacion}/rechazar', [\App\Http\Controllers\Empresa\PostulacionController::class, 'rechazar'])
            ->name('postulaciones.rechazar');
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

        // Postular
        Route::get('practicas/{practica}/postular', [\App\Http\Controllers\Alumno\PostulacionController::class, 'store'])
            ->name('practicas.postular');


        // Google Drive Connection
        Route::middleware(['web'])->group(function () {
            Route::get('/drive/conectar', [EntregaController::class, 'conectarDrive'])
                ->name('drive.conectar');
            Route::get('/drive/callback', [EntregaController::class, 'callbackDrive'])
                ->name('drive.callback');
        });

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

        Route::delete('fichas/{fichaRegistro}', [FichaRegistroController::class, 'destroy'])
            ->name('ficha.destroy');

        Route::get(
            'fichas/{fichaRegistro}/download-pdf',
            [FichaRegistroController::class, 'downloadPdf']
        )->name('ficha.download-pdf');

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

        Route::delete('/cronograma/{cronograma}', [CronogramaController::class, 'destroy'])
            ->name('cronograma.destroy');

        Route::get(
            'cronograma/{cronograma}/download-pdf',
            [CronogramaController::class, 'downloadPdf']
        )->name('cronograma.download-pdf');


        // Gestión del Aula
        Route::get('/aula/{aula}', [\App\Http\Controllers\Alumno\AulaController::class, 'index'])
            ->name('aula.index');

        // Gestión de Entregas
        Route::get('/entregas/crear/{actividad}', [\App\Http\Controllers\Alumno\EntregaController::class, 'create'])
            ->name('entregas.create');
        Route::post('/entregas/guardar/{actividad}', [\App\Http\Controllers\Alumno\EntregaController::class, 'store'])
            ->name('entregas.store');
        Route::get('/entregas/{entrega}', [\App\Http\Controllers\Alumno\EntregaController::class, 'show'])
            ->name('entregas.show');
        Route::get('/entregas/{entrega}/editar', [\App\Http\Controllers\Alumno\EntregaController::class, 'edit'])
            ->name('entregas.edit');
        Route::put('/entregas/{entrega}', [\App\Http\Controllers\Alumno\EntregaController::class, 'update'])
            ->name('entregas.update');
        Route::get('/entregas/{entrega}/descargar', [\App\Http\Controllers\Alumno\EntregaController::class, 'download'])
            ->name('entregas.download');
        Route::delete('/entregas/{entrega}', [\App\Http\Controllers\Alumno\EntregaController::class, 'destroy'])
            ->name('entregas.destroy');

        // Informe Final
        Route::get('informe-final', [\App\Http\Controllers\Alumno\InformeFinalController::class, 'index'])
            ->name('informe-final.index');
        Route::post('informe-final', [\App\Http\Controllers\Alumno\InformeFinalController::class, 'store'])
            ->name('informe-final.store');
        Route::get('informe-final/download', [\App\Http\Controllers\Alumno\InformeFinalController::class, 'download'])
            ->name('informe-final.download');
    });

Route::get('/firmas/ficha-registro/{token}', [FirmaTokenController::class, 'show'])
    ->name('firmas.ficha-registro.show');

Route::post('/firmar/{token}', [FirmaTokenController::class, 'store'])
    ->name('firmas.ficha-registro.store');


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


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/google/auth', [GoogleDriveController::class, 'redirectToGoogle'])->name('google.auth');
    Route::get('/google/callback', [GoogleDriveController::class, 'handleGoogleCallback'])->name('google.callback');
});

require __DIR__.'/auth.php';
