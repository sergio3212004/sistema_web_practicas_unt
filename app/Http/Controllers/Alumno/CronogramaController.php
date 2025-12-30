<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Mail\FirmaCronogramaMail;
use App\Models\Cronograma;
use App\Models\FichaRegistro;
use App\Models\FirmaToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CronogramaController extends Controller
{
    /**
     * Muestra el formulario para crear el cronograma
     */
    public function create(FichaRegistro $fichaRegistro)
    {
        // Verificar que la ficha esté aceptada
        if (!$fichaRegistro->aceptado) {
            return redirect()->back()->with('error', 'La ficha de registro debe estar aceptada para crear el cronograma.');
        }

        // Verificar que no tenga ya un cronograma
        if ($fichaRegistro->cronograma) {
            return redirect()->route('alumno.cronograma.show', $fichaRegistro->cronograma)
                ->with('info', 'Este cronograma ya existe.');
        }

        // Cargar relaciones necesarias
        $fichaRegistro->load(['horarios', 'alumno.user', 'alumno.aula.profesor.user', 'semestre']);

        return view('alumno.cronograma.create', compact('fichaRegistro'));
    }

    /**
     * Guarda el cronograma con la firma del practicante
     */
    public function store(Request $request, FichaRegistro $fichaRegistro)
    {
        $request->validate([
            'actividades' => 'required|array|min:1|max:5',
            'actividades.*.nombre' => 'required|string|max:500',
            'actividades.*.semanas' => 'required|array',
            'firma_practicante' => 'required|string', // Base64 de la firma
        ]);

        try {
            DB::beginTransaction();

            // Crear el cronograma
            $cronograma = Cronograma::create([
                'ficha_id' => $fichaRegistro->id,
                'firma_practicante_at' => now(),
            ]);

            // Guardar actividades
            foreach ($request->actividades as $actividad) {
                $data = [
                    'cronograma_id' => $cronograma->id,
                    'actividad' => $actividad['nombre'],
                ];

                // Procesar las semanas marcadas
                foreach ($actividad['semanas'] as $semana) {
                    $data[$semana] = true;
                }

                $cronograma->actividades()->create($data);
            }

            // Guardar la firma del practicante (opcional: como archivo)
            $firmaData = $request->firma_practicante;
            $firmaPath = $this->guardarFirma($firmaData, 'practicante', $cronograma->id);

            // Generar tokens para firmas pendientes
            $this->generarTokensFirma($cronograma, $fichaRegistro);

            DB::commit();

            return redirect()->route('alumno.cronograma.show', $cronograma)
                ->with('success', 'Cronograma creado exitosamente. Se han enviado correos para las firmas pendientes.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el cronograma: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el cronograma
     */
    public function show(Cronograma $cronograma)
    {
        $cronograma->load([
            'fichaRegistro.alumno.user',
            'fichaRegistro.alumno.aula.profesor.user',
            'fichaRegistro.horarios',
            'actividades'
        ]);

        return view('alumno.cronograma.show', compact('cronograma'));
    }

    /**
     * Genera tokens de firma para jefe y profesor
     */
    private function generarTokensFirma(Cronograma $cronograma, FichaRegistro $fichaRegistro)
    {
        // Token para el jefe directo
        $tokenJefe = FirmaToken::create([
            'ficha_registro_id' => $fichaRegistro->id,
            'email' => $fichaRegistro->correo_jefe_directo,
            'tipo' => 'jefe_directo',
            'contexto' => 'cronograma',
            'cronograma_id' => $cronograma->id,
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        // Token para el profesor
        $profesor = $fichaRegistro->alumno->aula->profesor;
        $tokenProfesor = FirmaToken::create([
            'ficha_registro_id' => $fichaRegistro->id,
            'email' => $profesor->user->email,
            'tipo' => 'profesor',
            'contexto' => 'cronograma',
            'cronograma_id' => $cronograma->id,
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        // Enviar correos
        $this->enviarCorreoFirma($tokenJefe, $fichaRegistro, 'jefe');
        $this->enviarCorreoFirma($tokenProfesor, $fichaRegistro, 'profesor');
    }

    /**
     * Envía correo con link de firma
     */
    private function enviarCorreoFirma(FirmaToken $token, FichaRegistro $fichaRegistro, $tipoDestinatario)
    {
        $url = route('firma.cronograma', ['token' => $token->token]);

        $datosCorreo = [
            'alumno' => $fichaRegistro->alumno->nombre_completo,
            'empresa' => $fichaRegistro->razon_social,
            'url' => $url,
            'tipo' => $tipoDestinatario,
            'expira' => $token->expires_at->format('d/m/Y H:i'),
        ];

        // Aquí implementarías el envío del correo
        Mail::to($token->email)->send(new FirmaCronogramaMail($datosCorreo));
    }

    /**
     * Guarda la firma como imagen (opcional)
     */
    private function guardarFirma($base64Data, $tipo, $cronogramaId)
    {
        // Decodificar base64
        $image = str_replace('data:image/png;base64,', '', $base64Data);
        $image = str_replace(' ', '+', $image);
        $imageName = "firma_{$tipo}_{$cronogramaId}_" . time() . '.png';

        // Guardar en storage
        $path = storage_path('app/public/firmas/cronogramas/');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . $imageName, base64_decode($image));

        return 'firmas/cronogramas/' . $imageName;
    }
}
