<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AulaController extends Controller
{

    /**
     * Ver detalle de un aula
     */
    public function show(Aula $aula)
    {
        $profesor = Auth::user()->profesor;

        // Seguridad: el aula debe pertenecer al profesor
        abort_if($aula->profesor_id !== $profesor->id, 403);

        $aula->load([
            'semestre',
            'alumnos.user',
            'alumnos.fichaRegistro.cronograma'
        ]);


        return view('profesor.aulas.show', compact('aula', 'profesor'));
    }
}
