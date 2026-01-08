<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // Lógica específica para el administrador
        if ($user->rol->nombre == 'administrador') {
            $data['semestres'] = Semestre::orderByDesc('id')->get();
            $data['administrador'] = $user->administrador; // Carga la relación
        }

        if ($user->rol->nombre == 'alumno') {
            $data['alumno'] = $user->alumno->load('aula.semestre');
        }


        // Lógica para el profesor
        if ($user->rol->nombre == 'profesor') {
            $profesor = $user->profesor;

            // Cargar aulas con sus relaciones necesarias
            $aulas = $profesor->aulas()
                ->with([
                    'semestre',
                    'alumnos',
                    'semanas',
                    'actividades.entregas'
                ])
                ->get();

            // Calcular total de entregas en todas las aulas
            $totalEntregas = $aulas->sum(function ($aula) {
                return $aula->actividades->sum(function ($actividad) {
                    return $actividad->entregas->count();
                });
            });

            // Calcular actividades activas (entre fecha_inicio y fecha_limite)
            $actividadesActivas = $aulas->sum(function ($aula) {
                return $aula->actividades->filter(function ($actividad) {
                    return $actividad->estaActiva();
                })->count();
            });

            $data['profesor'] = $profesor;
            $data['aulas'] = $aulas;
            $data['totalEntregas'] = $totalEntregas;
            $data['actividadesActivas'] = $actividadesActivas;
            $data['semestreActivo'] = Semestre::where('activo', true)->first();
        }

        if ($user->rol->nombre == 'empresa') {
            $data['empresa'] = $user->empresa->load('razonSocial', 'publicacion.postulaciones');
        }


        return view('dashboard', $data);
    }
}
