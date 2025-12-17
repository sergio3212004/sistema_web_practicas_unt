<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
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

        // Obtener todas las entregas del profesor con las entregas de alumnos
        $entregas = \App\Models\Entrega::where('profesor_id', $profesor->id)
            ->with(['entregas_alumnos.alumno'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profesor.entregas.index', compact('entregas'));
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
}
