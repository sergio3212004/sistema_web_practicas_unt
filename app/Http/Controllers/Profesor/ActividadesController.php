<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Actividad;
use App\Models\Semana;
use App\Models\TipoActividad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ActividadesController extends Controller
{
    /**
     * Show the form for creating a new actividad.
     */
    public function create(Aula $aula)
    {
        $profesor = Auth::user()->profesor;

        // ✅ Corrección: permiso debe ser !==
        if ($aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para acceder a esta aula.');
        }

        // Cargar relaciones necesarias para el formulario
        $aula->load('semestre', 'semanas');

        // Semanas ordenadas por número
        $semanas = $aula->semanas()->orderBy('numero')->get();

        // Tipos de actividad (asumiendo que existen en BD)
        $tiposActividad = TipoActividad::all();

        return view('profesor.actividades.create', compact('aula', 'semanas', 'tiposActividad'));
    }

    /**
     * Store a newly created actividad in storage.
     */
    public function store(Request $request, Aula $aula)
    {
        $profesor = Auth::user()->profesor;

        if ($aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para crear actividades en esta aula.');
        }

        $request->validate([
            'semana_id' => [
                'required',
                Rule::exists('semanas', 'id')->where(function ($query) use ($aula) {
                    return $query->where('aula_id', $aula->id);
                }),
            ],
            'tipo_actividad_id' => 'required|exists:tipos_actividad,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_limite',
            'fecha_limite' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $actividad = new Actividad($request->only([
            'titulo',
            'descripcion',
            'fecha_inicio',
            'fecha_limite',
            'tipo_actividad_id',
            'semana_id',
        ]));

        $actividad->aula_id = $aula->id;
        $actividad->save();

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Actividad creada exitosamente.');
    }

    /**
     * Display the specified actividad.
     */
    public function show(Actividad $actividad)
    {
        $profesor = Auth::user()->profesor;

        if ($actividad->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para ver esta actividad.');
        }

        // Cargar relaciones para la vista
        $actividad->load([
            'aula.semestre',
            'semana',
            'tipoActividad',
            'entregas.alumno.user'
        ]);

        return view('profesor.actividades.show', compact('actividad'));
    }
    public function destroy(Actividad $actividad): RedirectResponse
    {
        //  Verifica permisos (¡importante!)
        $profesor = auth()->user()->profesor;
        if ($actividad->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para eliminar esta actividad.');
        }

        // Guarda la aula antes de eliminar la actividad
        $aula = $actividad->aula;

        // Elimina la actividad (y sus entregas, si tienes cascada configurada)
        $actividad->delete();

        // Redirige correctamente con mensaje de éxito
        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Actividad eliminada exitosamente.');
    }
}
