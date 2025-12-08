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
            $data['alumno'] = $user->alumno;
        }
        // Puedes agregar lógica para otros roles aquí (profesor, alumno, etc.)

        return view('dashboard', $data);
    }
}
