<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\MonitoreoPractica;
use App\Models\Semana;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MonitoreoPracticaController extends Controller
{
    //
    public function index(Alumno $alumno)
    {
        // Verificar que el alumno tenga ficha de registro aprobada
        if (!$alumno->fichaRegistro || $alumno->fichaRegistro->aceptado !== true) {
            return redirect()->back()->with('error', 'El alumno no tiene una ficha de registro aprobada.');
        }

        // Verificar que tenga cronograma
        if (!$alumno->fichaRegistro->cronograma) {
            return redirect()->back()->with('error', 'El alumno no tiene un cronograma asignado.');
        }

        // Obtener el aula del alumno
        $aula = $alumno->aula;

        if (!$aula) {
            return redirect()->back()->with('error', 'El alumno no está asignado a ninguna aula.');
        }

        // Obtener todas las semanas del aula con sus monitoreos
        $semanas = $aula->semanas()
            ->orderBy('numero')
            ->with(['monitoreosPracticas' => function ($query) use ($alumno) {
                $query->where('alumno_id', $alumno->id)
                    ->with(['monitoreosPracticasActividades.cronogramaActividad']);
            }])
            ->get();

        $cronograma = $alumno->fichaRegistro->cronograma;

        return view('profesor.monitoreos-practicas.index', compact('alumno', 'semanas', 'aula', 'cronograma'));
    }

    public function show(MonitoreoPractica $monitoreoPractica)
    {
        $user = Auth::user();
        $profesor = $user->profesor;

        // Verificar que el monitoreo pertenezca a un alumno del aula del profesor
        if ($monitoreoPractica->alumno->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tienes permiso para ver este monitoreo.');
        }

        $monitoreoPractica->load([
            'alumno.user',
            'alumno.aula.profesor.user',
            'semana',
            'cronograma.fichaRegistro',
            'monitoreosPracticasActividades.cronogramaActividad'
        ]);

        return view('profesor.monitoreos-practicas.show', compact('monitoreoPractica'));
    }

    /**
     * Actualiza las firmas del supervisor en las actividades del monitoreo
     */
    public function updateFirmas(Request $request, MonitoreoPractica $monitoreoPractica)
    {
        $user = Auth::user();
        $profesor = $user->profesor;

        // Verificar que el monitoreo pertenezca a un alumno del aula del profesor
        if ($monitoreoPractica->alumno->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tienes permiso para firmar este monitoreo.');
        }

        $validated = $request->validate([
            'firmas' => 'required|array|min:1',
            'firmas.*.actividad_id' => 'required|exists:monitoreos_practicas_actividades,id',
            'firmas.*.firma_supervisor' => 'required|string',
            'actividades' => 'nullable|array',
            'actividades.*.observacion' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Crear directorio base para las firmas si no existe
            $baseDir = "firmas/monitoreo-practica/alumno-{$monitoreoPractica->alumno_id}/semana-{$monitoreoPractica->semana_id}";

            // Actualizar las firmas
            foreach ($validated['firmas'] as $index => $firma) {
                $actividad = $monitoreoPractica->monitoreosPracticasActividades()
                    ->findOrFail($firma['actividad_id']);

                // Eliminar firma anterior si existe
                if ($actividad->firma_supervisor) {
                    Storage::disk('public')->delete($actividad->firma_supervisor);
                }

                // Guardar nueva firma
                $firmaSupervisorPath = $this->guardarFirma(
                    $firma['firma_supervisor'],
                    "{$baseDir}/actividad-{$actividad->cronograma_actividad_id}/supervisor.png"
                );

                // Preparar datos para actualizar
                $dataToUpdate = [
                    'firma_supervisor' => $firmaSupervisorPath,
                ];

                // Agregar observación si existe
                if (isset($validated['actividades'][$index]['observacion'])) {
                    $dataToUpdate['observacion'] = $validated['actividades'][$index]['observacion'];
                }

                $actividad->update($dataToUpdate);
            }

            DB::commit();

            return redirect()
                ->route('profesor.monitoreos-practicas.show', $monitoreoPractica)
                ->with('success', 'Firmas y observaciones guardadas exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error al guardar las firmas: ' . $e->getMessage());
        }
    }

    /**
     * Guarda una firma en base64 como archivo PNG
     */
    private function guardarFirma($firmaBase64, $ruta)
    {
        // Remover el prefijo data:image/png;base64,
        $firmaBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $firmaBase64);
        $firmaDecoded = base64_decode($firmaBase64);

        // Guardar en storage
        Storage::disk('public')->put($ruta, $firmaDecoded);

        return $ruta;
    }

    /**
     * Obtiene las actividades que corresponden a una semana específica
     */
    private function obtenerActividadesPorSemana($actividades, $numeroSemana)
    {
        // Mapeo de número de semana a campo en la base de datos
        $camposPorSemana = [
            1 => 'm1_s1', 2 => 'm1_s2', 3 => 'm1_s3', 4 => 'm1_s4',
            5 => 'm2_s1', 6 => 'm2_s2', 7 => 'm2_s3', 8 => 'm2_s4',
            9 => 'm3_s1', 10 => 'm3_s2', 11 => 'm3_s3', 12 => 'm3_s4',
            13 => 'm4_s1', 14 => 'm4_s2', 15 => 'm4_s3', 16 => 'm4_s4',
        ];

        if (!isset($camposPorSemana[$numeroSemana])) {
            return collect();
        }

        $campo = $camposPorSemana[$numeroSemana];

        return $actividades->filter(function ($actividad) use ($campo) {
            return $actividad->$campo == true || $actividad->$campo == 1;
        });
    }

    /**
     * Descarga el PDF del monitoreo de prácticas
     */
    public function downloadPdf(MonitoreoPractica $monitoreoPractica)
    {
        $user = Auth::user();
        $profesor = $user->profesor;

        // Verificar que el monitoreo pertenezca a un alumno del aula del profesor
        if ($monitoreoPractica->alumno->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tienes permiso para descargar este monitoreo.');
        }

        $monitoreoPractica->load([
            'alumno.user',
            'alumno.aula.profesor.user',
            'alumno.fichaRegistro',
            'semana',
            'cronograma.fichaRegistro',
            'monitoreosPracticasActividades.cronogramaActividad'
        ]);

        // Generar PDF
        $pdf = PDF::loadView('profesor.monitoreos-practicas.pdf', [
            'monitoreoPractica' => $monitoreoPractica
        ]);

        // Configurar el PDF
        $pdf->setPaper('a4', 'portrait');

        // Nombre del archivo
        $nombreArchivo = 'monitoreo-practica-semana-' . $monitoreoPractica->semana->numero .
            '-' . str_replace(' ', '-', $monitoreoPractica->alumno->user->nombre) .
            '.pdf';

        // Descargar el PDF
        return $pdf->download($nombreArchivo);
    }
}
