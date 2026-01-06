<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Semana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesor = Auth::user()->profesor;

        // Obtener todas las semanas de las aulas del profesor
        $semanas = Semana::whereHas('aula', function($query) use ($profesor) {
            $query->where('profesor_id', $profesor->id);
        })
            ->with(['aula.semestre', 'actividades'])
            ->orderBy('aula_id')
            ->orderBy('numero')
            ->get();

        return view('profesor.semanas.index', compact('semanas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Aula $aula)
    {
        // Verificar que el aula pertenezca al profesor autenticado
        $profesor = Auth::user()->profesor;

        if ($aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para acceder a esta aula.');
        }

        // Cargar relaciones necesarias
        $aula->load('semestre', 'semanas');
        //dd($aula->toArray(), $aula->semestre);

        // Obtener el último número de semana para sugerir el siguiente
        $ultimoNumero = $aula->semanas()->max('numero') ?? 0;
        $siguienteNumero = $ultimoNumero + 1;

        return view('profesor.semanas.create', compact('aula', 'siguienteNumero'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Aula $aula)
    {
        // Verificar que el aula pertenezca al profesor autenticado
        $profesor = Auth::user()->profesor;

        if ($aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para acceder a esta aula.');
        }

        $validated = $request->validate([
            'numero' => 'required|integer|min:1',
            'nombre' => 'nullable|string|max:255',
        ]);

        // Verificar que no exista una semana con el mismo número en esta aula
        $existeSemana = $aula->semanas()->where('numero', $validated['numero'])->exists();

        if ($existeSemana) {
            return back()
                ->withErrors(['numero' => 'Ya existe una semana con este número en esta aula.'])
                ->withInput();
        }

        $semana = $aula->semanas()->create($validated);

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Semana creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semana $semana)
    {
        // Verificar que la semana pertenezca a un aula del profesor
        $profesor = Auth::user()->profesor;

        if ($semana->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para ver esta semana.');
        }

        $semana->load(['aula.semestre', 'actividades.tipoActividad', 'actividades.entregas']);

        return view('profesor.semanas.show', compact('semana'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semana $semana)
    {
        // Verificar que la semana pertenezca a un aula del profesor
        $profesor = Auth::user()->profesor;

        if ($semana->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para editar esta semana.');
        }

        // Cargar relaciones necesarias
        $semana->load('aula.semestre', 'actividades.tipoActividad');

        return view('profesor.semanas.edit', compact('semana'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semana $semana)
    {
        // Verificar que la semana pertenezca a un aula del profesor
        $profesor = Auth::user()->profesor;

        if ($semana->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para actualizar esta semana.');
        }

        $validated = $request->validate([
            'numero' => 'required|integer|min:1',
            'nombre' => 'nullable|string|max:255',
        ]);

        // Verificar que no exista otra semana con el mismo número en esta aula
        $existeSemana = $semana->aula->semanas()
            ->where('numero', $validated['numero'])
            ->where('id', '!=', $semana->id)
            ->exists();

        if ($existeSemana) {
            return back()
                ->withErrors(['numero' => 'Ya existe otra semana con este número en esta aula.'])
                ->withInput();
        }

        $semana->update($validated);

        return redirect()
            ->route('profesor.aulas.show', $semana->aula)
            ->with('success', 'Semana actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semana $semana)
    {
        // Verificar que la semana pertenezca a un aula del profesor
        $profesor = Auth::user()->profesor;

        if ($semana->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para eliminar esta semana.');
        }

        $aula = $semana->aula;

        // Eliminar la semana (las actividades se eliminarán en cascada si está configurado)
        $semana->delete();

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Semana eliminada exitosamente.');
    }
}
