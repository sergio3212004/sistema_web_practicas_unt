<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    //
    /**
     * Muestra los informes de entregas de los alumnos
     */
    public function index()
    {
        $profesor = auth()->user()->profesor;

        $entregas = Entrega::where('profesor_id', $profesor->id)
            ->with(['entregas_alumnos.alumno'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 🔹 Obtener última entrega
        $ultimaEntrega = Entrega::where('profesor_id', $profesor->id)
            ->orderBy('id', 'desc')
            ->first();

        // 🔹 Semana sugerida
        $semanaSugerida = 1;

        if ($ultimaEntrega && preg_match('/Semana (\d+)/', $ultimaEntrega->titulo, $matches)) {
            $semanaSugerida = min(((int) $matches[1]) + 1, 14);
        }

        return view(
            'profesor.entregas.index',
            compact('entregas', 'semanaSugerida')
        );
    }


    /**
     * Muestra el formulario para crear una nueva entrega
     */
    public function create()
    {
        $profesor = auth()->user()->profesor;

        $aula = $profesor->aulas()->with('semestre')->first();

        $entregas = \App\Models\Entrega::where('profesor_id', $profesor->id)
            ->with(['entregas_alumnos.alumno'])
            ->orderBy('created_at', 'desc')
            ->get();

        $ultimaEntrega = \App\Models\Entrega::where('profesor_id', $profesor->id)
            ->orderBy('id', 'desc')
            ->first();

        $semanaSugerida = 1;
        if ($ultimaEntrega && preg_match('/Semana (\d+)/', $ultimaEntrega->titulo, $matches)) {
            $semanaSugerida = min(((int) $matches[1]) + 1, 14);
        }

        return view(
            'profesor.entregas.create',
            compact('profesor', 'aula', 'entregas', 'semanaSugerida')
        );
    }


    /**
     * Guarda una nueva entrega en la base de datos
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        // Obtener el profesor autenticado
        $profesor = auth()->user()->profesor;

        // Obtener el aula del profesor
        $aula = $profesor->aulas()->first();

        // Crear la entrega
        $entrega = \App\Models\Entrega::create([
            'profesor_id' => $profesor->id,
            'aula_id' => $aula->id,
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
        ]);

        return redirect()->route('profesor.entregas.create')
            ->with('success', '¡Entrega creada exitosamente! Los alumnos ya pueden verla.');
    }

    public function show($id)
    {
        $entrega = \App\Models\Entrega::with([
            'aula.alumnos',
            'entregas_alumnos.alumno'
        ])->findOrFail($id);

        return view('profesor.entregas.show', compact('entrega'));
    }

    public function calificar(Request $request, $entregaId, $alumnoId)
    {
        $request->validate([
            'nota' => 'nullable|numeric|min:0|max:20',
            'comentario_profesor' => 'nullable|string|max:500',
        ]);

        $entregaAlumno = \App\Models\EntregaAlumno::where('entrega_id', $entregaId)
            ->where('alumno_id', $alumnoId)
            ->firstOrFail();

        $entregaAlumno->update([
            'nota' => $request->nota,
            'comentario_profesor' => $request->comentario_profesor,
            'fecha_revision' => now(),
        ]);

        return back()->with('success', 'Calificación guardada correctamente');
    }


    public function verEntregaAlumno($entregaId, $alumnoId)
    {
        $entrega = \App\Models\Entrega::with('aula')->findOrFail($entregaId);

        $entregaAlumno = \App\Models\EntregaAlumno::with('alumno')
            ->where('entrega_id', $entregaId)
            ->where('alumno_id', $alumnoId)
            ->firstOrFail();

        return view(
            'profesor.entregas.calificar',
            compact('entrega', 'entregaAlumno')
        );
    }

    public function guardarCalificacion(Request $request, $entregaId, $alumnoId)
    {
        $request->validate([
            'nota' => 'required|numeric|min:0|max:20',
            'comentario_profesor' => 'nullable|string|max:500',
        ]);

        $entregaAlumno = \App\Models\EntregaAlumno::where('entrega_id', $entregaId)
            ->where('alumno_id', $alumnoId)
            ->firstOrFail();

        $entregaAlumno->update([
            'nota' => $request->nota,
            'comentario_profesor' => $request->comentario_profesor,
            'fecha_revision' => now(),
        ]);

        return redirect()
            ->route('profesor.entregas.show', $entregaId)
            ->with('success', 'Calificación guardada correctamente');
    }


}
