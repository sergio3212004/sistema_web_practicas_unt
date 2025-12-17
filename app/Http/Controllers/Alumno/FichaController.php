<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\FichaRegistro;
use App\Models\Alumno;
use App\Models\Semestre;
use App\Models\RazonSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener el alumno actual del usuario autenticado
        $alumno = Alumno::where('user_id', Auth::id())->first();

        if (!$alumno) {
            return redirect()->back()->with('error', 'No se encontró información del alumno');
        }

        // Obtener todas las fichas del alumno
        $fichas = FichaRegistro::where('alumno_id', $alumno->id)
            ->with(['semestre', 'razonSocial', 'horarios'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('alumno.ficha-registro.index', compact('fichas', 'alumno'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener el alumno actual del usuario autenticado
        $alumno = Alumno::where('user_id', Auth::id())->first();

        if (!$alumno) {
            return redirect()->back()->with('error', 'No se encontró información del alumno');
        }

        // Obtener el semestre activo
        $semestreActivo = Semestre::where('activo', true)->first();

        if (!$semestreActivo) {
            return redirect()->back()->with('error', 'No hay un semestre activo');
        }

        // Obtener todas las razones sociales (empresas registradas)
        $empresas = RazonSocial::with('empresa')->orderBy('acronimo', 'asc')->get();

        // Días de la semana para el formulario
        $diasSemana = [
            1 => 'LUNES',
            2 => 'MARTES',
            3 => 'MIÉRCOLES',
            4 => 'JUEVES',
            5 => 'VIERNES',
            6 => 'SÁBADO'
        ];

        return view('alumno.ficha-registro.create', compact('alumno', 'semestreActivo', 'empresas', 'diasSemana'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'razon_social_acronimo' => 'required|string|max:20',
            'ruc' => 'required|string|max:11',
            'nombre_gerente' => 'required|string|max:255',
            'nombre_jefe_rrhh' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono_fijo' => 'nullable|string|max:20',
            'telefono_movil' => 'required|string|max:20',
            'departamento' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'distrito' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after:fecha_inicio',
            'descripcion' => 'required|string|max:1000',
            'area_practicas' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'nombre_jefe_directo' => 'required|string|max:255',
            'telefono_jefe_directo' => 'required|string|max:20',
            'correo_jefe_directo' => 'required|email|max:255',
            'horarios' => 'required|array',
            'firma_practicante' => 'nullable|string',
        ]);



        // Obtener el alumno actual
        $alumno = Alumno::where('user_id', Auth::id())->first();

        if (!$alumno) {
            return redirect()->back()->with('error', 'No se encontró información del alumno');
        }

        $firmaPath = null;

        if ($request->filled('firma_practicante')) {
            $image = str_replace('data:image/png;base64,', '', $request->firma_practicante);
            $image = base64_decode($image);

            $fileName = 'firmas/practicante_' . uniqid() . '.png';
            \Storage::disk('public')->put($fileName, $image);

            $firmaPath = $fileName;
        }


        // Obtener el semestre activo
        $semestreActivo = Semestre::where('activo', true)->first();

        $razonSocialFinal = $validated['nombre_empresa']
            . ' - ' . $validated['razon_social_acronimo'];

        $ficha = FichaRegistro::create([
            'alumno_id' => $alumno->id,
            'ciclo' => $alumno->aula->ciclo ?? null,
            'semestre_id' => $semestreActivo->id,
            'razon_social' => $razonSocialFinal,
            'ruc' => $validated['ruc'],
            'nombre_gerente' => $validated['nombre_gerente'],
            'nombre_jefe_rrhh' => $validated['nombre_jefe_rrhh'],
            'direccion' => $validated['direccion'],
            'telefono_fijo' => $validated['telefono_fijo'],
            'telefono_movil' => $validated['telefono_movil'],
            'departamento' => $validated['departamento'],
            'provincia' => $validated['provincia'],
            'distrito' => $validated['distrito'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_termino' => $validated['fecha_termino'],
            'descripcion' => $validated['descripcion'],
            'area_practicas' => $validated['area_practicas'],
            'cargo' => $validated['cargo'],
            'nombre_jefe_directo' => $validated['nombre_jefe_directo'],
            'telefono_jefe_directo' => $validated['telefono_jefe_directo'],
            'correo_jefe_directo' => $validated['correo_jefe_directo'],
            'firma_practicante' => $firmaPath,
            'aceptado' => false,
        ]);


        // Crear los horarios
        foreach ($validated['horarios'] as $horario) {
            $ficha->horarios()->create([
                'dia_semana' => $horario['dia_semana'],
                'hora_inicio' => $horario['hora_inicio'],
                'hora_fin' => $horario['hora_fin'],
            ]);
        }

        return redirect()->route('alumno.ficha-registro.index')
            ->with('success', 'Ficha de registro creada exitosamente. Pendiente de aprobación.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ficha = FichaRegistro::with(['alumno', 'semestre', 'razonSocial', 'horarios'])
            ->findOrFail($id);

        // Verificar que la ficha pertenezca al alumno actual
        $alumno = Alumno::where('user_id', Auth::id())->first();

        if ($ficha->alumno_id !== $alumno->id) {
            return redirect()->back()->with('error', 'No tienes permiso para ver esta ficha');
        }

        return view('alumno.ficha-registro.show', compact('ficha'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
