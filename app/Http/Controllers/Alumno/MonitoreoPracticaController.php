<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\MonitoreoPractica;
use App\Models\Semana;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MonitoreoPracticaController extends Controller
{
    //
    public function index(Semana $semana)
    {
        $user = Auth::user();
        $alumno = $user->alumno;

        $monitoreo = $alumno->monitoreosPracticas()
            ->where('semana_id', $semana->id)
            ->first();

        return view('alumno.monitoreo-practica.index', compact('semana', 'monitoreo'));
    }

    public function show(MonitoreoPractica $monitoreoPractica)
    {
        $user = Auth::user();
        $alumno = $user->alumno;

        // Verificar que el monitoreo pertenezca al alumno autenticado
        if ($monitoreoPractica->alumno_id !== $alumno->id) {
            return redirect()->back()->with('error', 'No tienes permiso para ver este monitoreo.');
        }

        $monitoreoPractica->load([
            'alumno.user',
            'alumno.aula.profesor.user',
            'alumno.fichaRegistro',
            'semana',
            'cronograma.fichaRegistro',
            'monitoreosPracticasActividades.cronogramaActividad'
        ]);

        return view('alumno.monitoreo-practica.show', compact('monitoreoPractica'));
    }

    public function downloadPdf(MonitoreoPractica $monitoreoPractica)
    {
        $user = Auth::user();
        $alumno = $user->alumno;

        // Verificar que el monitoreo pertenezca al alumno autenticado
        if ($monitoreoPractica->alumno_id !== $alumno->id) {
            abort(403, 'No tienes permiso para descargar este documento.');
        }

        $monitoreoPractica->load([
            'alumno.user',
            'alumno.aula.profesor.user',
            'alumno.fichaRegistro',
            'semana',
            'cronograma.fichaRegistro',
            'monitoreosPracticasActividades.cronogramaActividad'
        ]);

        $pdf = PDF::loadView('alumno.monitoreo-practica.pdf', compact('monitoreoPractica'));

        $nombreArchivo = 'Monitoreo_Practicas_Semana_' . $monitoreoPractica->semana->numero . '_' .
            str_replace(' ', '_', $monitoreoPractica->alumno->user->nombre) . '.pdf';

        return $pdf->download($nombreArchivo);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $alumno = $user->alumno;
        $semanaId = $request->query('semana_id');

        if (!$semanaId) {
            return redirect()->back()->with('error', 'Parámetro semana_id faltante.');
        }

        $semana = Semana::findOrFail($semanaId);

        // Verificar que el alumno tenga ficha de registro aprobada
        if (!$alumno->fichaRegistro || $alumno->fichaRegistro->aceptado !== true) {
            return redirect()->back()->with('error', 'No tienes una ficha de registro aprobada.');
        }

        // Verificar que tenga cronograma
        if (!$alumno->fichaRegistro->cronograma) {
            return redirect()->back()->with('error', 'No tienes un cronograma asignado.');
        }

        // Verificar que esté asignado a un aula
        if (!$alumno->aula) {
            return redirect()->back()->with('error', 'No estás asignado a ninguna aula.');
        }

        // Verificar que no exista ya un monitoreo para esta semana
        $monitoreoExistente = MonitoreoPractica::where('alumno_id', $alumno->id)
            ->where('semana_id', $semana->id)
            ->first();

        if ($monitoreoExistente) {
            return redirect()->route('alumno.monitoreos-practicas.show', $monitoreoExistente)
                ->with('info', 'Ya existe un monitoreo para esta semana.');
        }

        $cronograma = $alumno->fichaRegistro->cronograma;

        // Obtener actividades que corresponden a esta semana
        $numeroSemana = $semana->numero;
        $actividadesSemana = $this->obtenerActividadesPorSemana($cronograma->actividades, $numeroSemana);

        if ($actividadesSemana->isEmpty()) {
            return redirect()->back()->with('error', 'No hay actividades programadas para esta semana.');
        }

        return view('alumno.monitoreo-practica.create', compact(
            'alumno',
            'semana',
            'cronograma',
            'actividadesSemana'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $alumno = $user->alumno;

        $validated = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'semana_id' => 'required|exists:semanas,id',
            'cronograma_id' => 'required|exists:cronogramas,id',
            'actividades' => 'required|array|min:1',
            'actividades.*.cronograma_actividad_id' => 'required|exists:cronograma_actividades,id',
            'actividades.*.fecha' => 'required|date',
            'actividades.*.al_dia' => 'required|boolean',
            'actividades.*.observacion' => 'nullable|string|max:500',
            'actividades.*.firma_practicante' => 'required|string',
        ]);

        // Verificar que el alumno_id coincida con el usuario autenticado
        if ($validated['alumno_id'] != $alumno->id) {
            return redirect()->back()->with('error', 'No tienes permiso para crear este monitoreo.');
        }

        try {
            DB::beginTransaction();

            // Verificar que no exista ya un monitoreo
            $monitoreoExistente = MonitoreoPractica::where('alumno_id', $validated['alumno_id'])
                ->where('semana_id', $validated['semana_id'])
                ->first();

            if ($monitoreoExistente) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Ya existe un monitoreo para esta semana.');
            }

            // Crear el monitoreo principal
            $monitoreo = MonitoreoPractica::create([
                'cronograma_id' => $validated['cronograma_id'],
                'semana_id' => $validated['semana_id'],
                'alumno_id' => $validated['alumno_id'],
            ]);

            // Crear directorio base para las firmas si no existe
            $baseDir = "firmas/monitoreo-practica/alumno-{$validated['alumno_id']}/semana-{$validated['semana_id']}";

            // Crear las actividades monitoreadas
            foreach ($validated['actividades'] as $index => $actividad) {
                // Guardar firma del practicante
                $firmaPracticantePath = null;
                if (!empty($actividad['firma_practicante'])) {
                    $firmaPracticantePath = $this->guardarFirma(
                        $actividad['firma_practicante'],
                        "{$baseDir}/actividad-{$actividad['cronograma_actividad_id']}/practicante.png"
                    );
                }

                $monitoreo->monitoreosPracticasActividades()->create([
                    'cronograma_actividad_id' => $actividad['cronograma_actividad_id'],
                    'fecha' => $actividad['fecha'],
                    'al_dia' => $actividad['al_dia'],
                    'observacion' => $actividad['observacion'] ?? null,
                    'firma_practicante' => $firmaPracticantePath,
                    'firma_supervisor' => null, // Se llenará cuando el profesor firme
                ]);
            }

            DB::commit();

            $semana = Semana::findOrFail($validated['semana_id']);

            return redirect()
                ->route('alumno.monitoreos-practicas.index', $semana)
                ->with('success', 'Monitoreo registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al registrar el monitoreo: ' . $e->getMessage());
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
}
