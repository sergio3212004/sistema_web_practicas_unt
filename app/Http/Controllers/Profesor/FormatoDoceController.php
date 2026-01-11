<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\FormatoDoce;
use App\Models\FormatoDoceAlumno;
use App\Models\Aula;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FormatoDoceController extends Controller
{
    /**
     * Mostrar las aulas del profesor
     */
    public function index()
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección');
        }

        // Obtener aulas del profesor con sus formatos (hasMany)
        $aulas = Aula::where('profesor_id', $profesor->id)
            ->with(['semestre', 'alumnos', 'formatosDoce'])
            ->get();

        return view('profesor.formato-doce.index', compact('aulas'));
    }

    /**
     * Mostrar lista de formatos de un aula
     */
    public function list(Aula $aula)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección');
        }

        $aula->load(['semestre', 'formatosDoce' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('profesor.formato-doce.list', compact('aula'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Aula $aula)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección');
        }

        $aula->load(['semestre', 'alumnos']);

        // Verificar que el aula tenga alumnos
        if ($aula->alumnos->count() === 0) {
            return redirect()->route('profesor.formato-doce.index')
                ->with('error', 'El aula no tiene alumnos asignados');
        }

        return view('profesor.formato-doce.create', compact('aula'));
    }

    /**
     * Obtener alumnos de un aula (JSON)
     */
    public function getAlumnos(Aula $aula)
    {
        $alumnos = Alumno::where('aula_id', $aula->id)
            ->select('id', 'codigo_matricula', 'nombres', 'apellido_paterno', 'apellido_materno')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombres')
            ->get()
            ->map(function($alumno) {
                return [
                    'id' => $alumno->id,
                    'codigo_matricula' => $alumno->codigo_matricula,
                    'nombre_completo' => $alumno->nombre_completo
                ];
            });

        return response()->json($alumnos);
    }

    /**
     * Guardar nuevo formato
     */
    public function store(Request $request, Aula $aula)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para realizar esta acción');
        }

        // Validación
        $validated = $request->validate([
            'nivel' => 'required|in:inicial,intermedio,avanzado',
            'firma_coordinador' => 'required|string',
            'alumnos' => 'required|array|min:1',
            'alumnos.*.alumno_id' => 'required|exists:alumnos,id',
            'alumnos.*.sede_practica' => 'required|string|max:255',
            'alumnos.*.responsable' => 'required|string|max:255',
            'alumnos.*.contacto_responsable' => 'required|string|max:255',
            'alumnos.*.al_dia' => 'required|in:0,1',
            'alumnos.*.observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Guardar la firma
            $firmaData = $request->firma_coordinador;
            $firmaData = str_replace('data:image/png;base64,', '', $firmaData);
            $firmaData = str_replace(' ', '+', $firmaData);
            $firmaName = 'firma_' . time() . '_' . uniqid() . '.png';

            Storage::disk('public')->put(
                'firmas/formato-12/' . $firmaName,
                base64_decode($firmaData)
            );

            // Crear el formato
            $formato = FormatoDoce::create([
                'aula_id' => $aula->id,
                'nivel' => $validated['nivel'],
                'firma_coordinador' => 'firmas/formato-12/' . $firmaName,
            ]);

            // Crear los registros de alumnos
            foreach ($validated['alumnos'] as $alumnoData) {
                FormatoDoceAlumno::create([
                    'formato_doce_id' => $formato->id,
                    'alumno_id' => $alumnoData['alumno_id'],
                    'sede_practica' => $alumnoData['sede_practica'],
                    'responsable' => $alumnoData['responsable'],
                    'contacto_responsable' => $alumnoData['contacto_responsable'],
                    'al_dia' => $alumnoData['al_dia'],
                    'observaciones' => $alumnoData['observaciones'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('profesor.formato-doce.list', $aula->id)
                ->with('success', 'Formato 12 creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();

            // Eliminar la firma si se creó
            if (isset($firmaName)) {
                Storage::disk('public')->delete('firmas/formato-12/' . $firmaName);
            }

            return back()->withInput()
                ->with('error', 'Error al crear el formato: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar un formato específico
     */
    public function show($id)
    {
        $profesor = Auth::user()->profesor;

        $formato = FormatoDoce::with([
            'aula.semestre',
            'aula.profesor',
            'formatosDoceAlumnos.alumno'
        ])->findOrFail($id);

        if (!$profesor || $formato->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para ver este formato');
        }

        return view('profesor.formato-doce.show', compact('formato'));
    }

    /**
     * Eliminar un formato
     */
    public function destroy($id)
    {
        $profesor = Auth::user()->profesor;

        $formato = FormatoDoce::findOrFail($id);

        if (!$profesor || $formato->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para eliminar este formato');
        }

        $aulaId = $formato->aula_id;

        DB::beginTransaction();
        try {
            // Eliminar la firma del storage
            if ($formato->firma_coordinador && Storage::disk('public')->exists($formato->firma_coordinador)) {
                Storage::disk('public')->delete($formato->firma_coordinador);
            }

            // Eliminar el formato (los registros de alumnos se eliminan por CASCADE)
            $formato->delete();

            DB::commit();

            return redirect()->route('profesor.formato-doce.list', $aulaId)
                ->with('success', 'Formato 12 eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el formato: ' . $e->getMessage());
        }
    }

    /**
     * Generar PDF del formato
     */
    public function pdf($id)
    {
        $profesor = Auth::user()->profesor;

        $formato = FormatoDoce::with([
            'aula.semestre',
            'aula.profesor',
            'formatosDoceAlumnos.alumno'
        ])->findOrFail($id);

        if (!$profesor || $formato->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para ver este formato');
        }

        $pdf = \PDF::loadView('profesor.formato-doce.pdf', compact('formato'), );

        $pdf->setPaper('A4', 'landscape');


        $filename = 'Formato_12_Monitoreo_PPP_' .
            str_replace(' ', '_', $formato->aula->semestre->nombre ?? 'N_A') . '_' .
            'Aula_' . ($formato->aula->numero ?? 'N_A') . '_' .
            date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
