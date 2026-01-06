<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;

class EntregaController extends Controller
{
    /**
     * Obtener cliente de Google Drive
     */
    protected function getGoogleClient()
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setScopes([
            GoogleDrive::DRIVE_READONLY,
            GoogleDrive::DRIVE_METADATA_READONLY
        ]);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        // Si hay token guardado, configurarlo
        if (Session::has('google_drive_token')) {
            $client->setAccessToken(Session::get('google_drive_token'));

            // Refrescar token si está expirado
            if ($client->isAccessTokenExpired()) {
                $refreshToken = $client->getRefreshToken();
                if ($refreshToken) {
                    $client->fetchAccessTokenWithRefreshToken($refreshToken);
                    Session::put('google_drive_token', $client->getAccessToken());
                }
            }
        }

        return $client;
    }

    /**
     * Verificar conexión con Google Drive
     */
    protected function verificarConexionDrive()
    {
        if (!Session::has('google_drive_token')) {
            return false;
        }

        $client = $this->getGoogleClient();
        return !$client->isAccessTokenExpired();
    }

    /**
     * Mostrar el formulario para crear una nueva entrega
     */
    public function create(Actividad $actividad)
    {
        $alumno = Auth::user()->alumno;

        // Verificar que el alumno pertenece al aula de la actividad
        if ($alumno->aula_id !== $actividad->aula_id) {
            abort(403, 'No tienes acceso a esta actividad.');
        }

        // Verificar que la actividad no esté vencida
        if ($actividad->estaVencida()) {
            return redirect()->back()->with('error', 'Esta actividad ya venció. No puedes realizar entregas.');
        }

        // Verificar si ya existe una entrega
        $entregaExistente = Entrega::where('actividad_id', $actividad->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        if ($entregaExistente) {
            return redirect()->route('alumno.entregas.show', $entregaExistente)
                ->with('info', 'Ya realizaste una entrega para esta actividad.');
        }

        // Cargar relaciones necesarias
        $actividad->load(['tipoActividad', 'semana', 'aula']);

        // Si es modo drive, verificar conexión
        $driveConectado = false;
        if ($actividad->tipoActividad->modo_entrega === 'drive') {
            $driveConectado = $this->verificarConexionDrive();
        }

        return view('alumno.entregas.create', compact('actividad', 'driveConectado'));
    }

    /**
     * Almacenar una nueva entrega
     */
    public function store(Request $request, Actividad $actividad)
    {
        $alumno = Auth::user()->alumno;

        // Validaciones
        if ($alumno->aula_id !== $actividad->aula_id) {
            abort(403, 'No tienes acceso a esta actividad.');
        }

        if ($actividad->estaVencida()) {
            return redirect()->back()->with('error', 'Esta actividad ya venció. No puedes realizar entregas.');
        }

        // Verificar si ya existe una entrega
        $entregaExistente = Entrega::where('actividad_id', $actividad->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        if ($entregaExistente) {
            return redirect()->route('alumno.entregas.show', $entregaExistente)
                ->with('error', 'Ya realizaste una entrega para esta actividad.');
        }

        $modoEntrega = $actividad->tipoActividad->modo_entrega;
        $ruta = null;

        // Validar según el modo de entrega
        if ($modoEntrega === 'pdf') {
            // Validar archivo PDF
            $request->validate([
                'archivo' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240',
                'observaciones' => 'nullable|string|max:500'
            ], [
                'archivo.required' => 'Debes adjuntar un archivo para la entrega.',
                'archivo.mimes' => 'El archivo debe ser PDF, DOC, DOCX, ZIP o RAR.',
                'archivo.max' => 'El archivo no puede superar los 10MB.'
            ]);

            // Guardar el archivo
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $alumno->id . '_' . $actividad->id . '.' . $archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('entregas', $nombreArchivo, 'public');

        } elseif ($modoEntrega === 'drive') {
            // Validar enlace de Google Drive
            $request->validate([
                'drive_file_id' => 'required|string',
                'drive_file_name' => 'required|string',
                'observaciones' => 'nullable|string|max:500'
            ], [
                'drive_file_id.required' => 'Debes seleccionar un archivo de Google Drive.',
                'drive_file_name.required' => 'El nombre del archivo es requerido.'
            ]);

            // Verificar que el archivo existe y es accesible
            try {
                $client = $this->getGoogleClient();
                $service = new GoogleDrive($client);

                $file = $service->files->get($request->drive_file_id, [
                    'fields' => 'id, name, mimeType, webViewLink'
                ]);

                // Guardar la información del archivo de Drive
                $ruta = json_encode([
                    'type' => 'drive',
                    'file_id' => $request->drive_file_id,
                    'file_name' => $request->drive_file_name,
                    'web_view_link' => $file->webViewLink ?? null,
                    'mime_type' => $file->mimeType ?? null
                ]);

            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'No se pudo verificar el archivo de Google Drive. Verifica que el archivo existe y tienes permisos.')
                    ->withInput();
            }
        }

        // Crear la entrega
        $entrega = Entrega::create([
            'actividad_id' => $actividad->id,
            'alumno_id' => $alumno->id,
            'ruta' => $ruta,
            'estado' => 'entregado',
            'observaciones' => $request->observaciones,
            'fecha_entrega' => now(),
        ]);

        return redirect()->route('alumno.aula.index', $actividad->aula_id)
            ->with('success', '¡Entrega realizada exitosamente!');
    }

    /**
     * Mostrar los detalles de una entrega específica
     */
    public function show(Entrega $entrega)
    {
        $alumno = Auth::user()->alumno;

        // Verificar que la entrega pertenece al alumno
        if ($entrega->alumno_id !== $alumno->id) {
            abort(403, 'No tienes acceso a esta entrega.');
        }

        // Cargar relaciones
        $entrega->load([
            'actividad.tipoActividad',
            'actividad.semana',
            'actividad.aula',
            'alumno.user'
        ]);

        // Si es una entrega de Drive, decodificar la información
        $driveInfo = null;
        if ($entrega->actividad->tipoActividad->modo_entrega === 'drive') {
            $driveInfo = json_decode($entrega->ruta, true);
        }

        return view('alumno.entregas.show', compact('entrega', 'driveInfo'));
    }

    /**
     * Mostrar el formulario para editar/reenviar una entrega
     */
    public function edit(Entrega $entrega)
    {
        $alumno = Auth::user()->alumno;

        // Verificar que la entrega pertenece al alumno
        if ($entrega->alumno_id !== $alumno->id) {
            abort(403, 'No tienes acceso a esta entrega.');
        }

        // Verificar que la actividad no esté vencida
        if ($entrega->actividad->estaVencida()) {
            return redirect()->back()->with('error', 'La actividad ya venció. No puedes modificar la entrega.');
        }

        // Solo permitir edición si está en estado 'rechazado' o 'observado'
        if (!in_array($entrega->estado, ['rechazado', 'observado'])) {
            return redirect()->back()->with('error', 'No puedes modificar esta entrega en su estado actual.');
        }

        // Cargar relaciones
        $entrega->load([
            'actividad.tipoActividad',
            'actividad.semana'
        ]);

        // Si es modo drive, verificar conexión
        $driveConectado = false;
        $driveInfo = null;
        if ($entrega->actividad->tipoActividad->modo_entrega === 'drive') {
            $driveConectado = $this->verificarConexionDrive();
            $driveInfo = json_decode($entrega->ruta, true);
        }

        return view('alumno.entregas.edit', compact('entrega', 'driveConectado', 'driveInfo'));
    }

    /**
     * Actualizar una entrega existente
     */
    public function update(Request $request, Entrega $entrega)
    {
        $alumno = Auth::user()->alumno;

        // Validaciones
        if ($entrega->alumno_id !== $alumno->id) {
            abort(403, 'No tienes acceso a esta entrega.');
        }

        if ($entrega->actividad->estaVencida()) {
            return redirect()->back()->with('error', 'La actividad ya venció. No puedes modificar la entrega.');
        }

        if (!in_array($entrega->estado, ['rechazado', 'observado'])) {
            return redirect()->back()->with('error', 'No puedes modificar esta entrega en su estado actual.');
        }

        $modoEntrega = $entrega->actividad->tipoActividad->modo_entrega;
        $ruta = null;

        // Validar según el modo de entrega
        if ($modoEntrega === 'pdf') {
            $request->validate([
                'archivo' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240',
                'observaciones' => 'nullable|string|max:500'
            ], [
                'archivo.required' => 'Debes adjuntar un archivo para la entrega.',
                'archivo.mimes' => 'El archivo debe ser PDF, DOC, DOCX, ZIP o RAR.',
                'archivo.max' => 'El archivo no puede superar los 10MB.'
            ]);

            // Eliminar archivo anterior si existe
            $oldInfo = json_decode($entrega->ruta, true);
            if (!isset($oldInfo['type']) || $oldInfo['type'] !== 'drive') {
                if ($entrega->ruta && Storage::disk('public')->exists($entrega->ruta)) {
                    Storage::disk('public')->delete($entrega->ruta);
                }
            }

            // Guardar nuevo archivo
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $alumno->id . '_' . $entrega->actividad_id . '.' . $archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('entregas', $nombreArchivo, 'public');

        } elseif ($modoEntrega === 'drive') {
            $request->validate([
                'drive_file_id' => 'required|string',
                'drive_file_name' => 'required|string',
                'observaciones' => 'nullable|string|max:500'
            ], [
                'drive_file_id.required' => 'Debes seleccionar un archivo de Google Drive.',
                'drive_file_name.required' => 'El nombre del archivo es requerido.'
            ]);

            try {
                $client = $this->getGoogleClient();
                $service = new GoogleDrive($client);

                $file = $service->files->get($request->drive_file_id, [
                    'fields' => 'id, name, mimeType, webViewLink'
                ]);

                $ruta = json_encode([
                    'type' => 'drive',
                    'file_id' => $request->drive_file_id,
                    'file_name' => $request->drive_file_name,
                    'web_view_link' => $file->webViewLink ?? null,
                    'mime_type' => $file->mimeType ?? null
                ]);

            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'No se pudo verificar el archivo de Google Drive.')
                    ->withInput();
            }
        }

        // Actualizar la entrega
        $entrega->update([
            'ruta' => $ruta,
            'estado' => 'entregado',
            'observaciones' => $request->observaciones,
            'fecha_entrega' => now(),
            'nota' => null,
        ]);

        return redirect()->route('alumno.entregas.show', $entrega)
            ->with('success', '¡Entrega actualizada exitosamente!');
    }

    /**
     * Descargar el archivo de una entrega o redirigir a Google Drive
     */
    public function download(Entrega $entrega)
    {
        $alumno = Auth::user()->alumno;

        // Verificar que la entrega pertenece al alumno
        if ($entrega->alumno_id !== $alumno->id) {
            abort(403, 'No tienes acceso a esta entrega.');
        }

        // Verificar si es una entrega de Drive
        $driveInfo = json_decode($entrega->ruta, true);
        if (isset($driveInfo['type']) && $driveInfo['type'] === 'drive') {
            // Redirigir a Google Drive
            if (isset($driveInfo['web_view_link'])) {
                return redirect($driveInfo['web_view_link']);
            }
            return redirect()->back()->with('error', 'No se encontró el enlace de Google Drive.');
        }

        // Es un archivo normal, descargarlo
        if (!$entrega->ruta || !Storage::disk('public')->exists($entrega->ruta)) {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }

        $nombreOriginal = basename($entrega->ruta);
        $extension = pathinfo($entrega->ruta, PATHINFO_EXTENSION);
        $nombreDescarga = 'Entrega_' . $entrega->actividad->titulo . '_' . $alumno->codigo_matricula . '.' . $extension;

        return Storage::disk('public')->download($entrega->ruta, $nombreDescarga);
    }

    /**
     * Eliminar una entrega (solo si no ha sido calificada)
     */
    public function destroy(Entrega $entrega)
    {
        $alumno = Auth::user()->alumno;

        // Verificar que la entrega pertenece al alumno
        if ($entrega->alumno_id !== $alumno->id) {
            abort(403, 'No tienes acceso a esta entrega.');
        }

        // No permitir eliminar si ya fue calificada
        if ($entrega->estaCalificada()) {
            return redirect()->back()->with('error', 'No puedes eliminar una entrega que ya fue calificada.');
        }

        // Verificar que la actividad no esté vencida
        if ($entrega->actividad->estaVencida()) {
            return redirect()->back()->with('error', 'No puedes eliminar la entrega de una actividad vencida.');
        }

        $aulaId = $entrega->actividad->aula_id;

        // Eliminar archivo solo si no es de Drive
        $driveInfo = json_decode($entrega->ruta, true);
        if (!isset($driveInfo['type']) || $driveInfo['type'] !== 'drive') {
            if ($entrega->ruta && Storage::disk('public')->exists($entrega->ruta)) {
                Storage::disk('public')->delete($entrega->ruta);
            }
        }

        // Eliminar registro
        $entrega->delete();

        return redirect()->route('alumno.aula.index', $aulaId)
            ->with('success', 'Entrega eliminada exitosamente.');
    }

    /**
     * Conectar con Google Drive
     */
    public function conectarDrive()
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();

        // Guardar la URL de retorno en sesión
        Session::put('drive_return_url', url()->previous());

        return redirect($authUrl);
    }

    /**
     * Callback de Google Drive
     */
    public function callbackDrive(Request $request)
    {
        if (!$request->has('code')) {
            return redirect(Session::get('drive_return_url', route('dashboard')))
                ->with('error', 'No se recibió autorización de Google Drive');
        }

        $client = $this->getGoogleClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return redirect(Session::get('drive_return_url', route('dashboard')))
                ->with('error', 'Error al conectar con Google Drive');
        }

        // Guardar el token en la sesión
        Session::put('google_drive_token', $token);

        $returnUrl = Session::get('drive_return_url', route('dashboard'));
        Session::forget('drive_return_url');

        return redirect($returnUrl)
            ->with('success', 'Google Drive conectado exitosamente');
    }
}
