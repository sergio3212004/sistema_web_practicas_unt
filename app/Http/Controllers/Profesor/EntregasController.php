<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntregasController extends Controller
{
    //
    public function calificar(Request $request, Entrega $entrega)
    {
        $profesor = Auth::user()->profesor;
        if ($entrega->actividad->aula->profesor_id !== $profesor->id) {
            abort(403, 'No tienes permiso para calificar esta entrega.');
        }

        $request->validate([
            'nota' => 'required|numeric|min:0|max:20',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $entrega->update([
            'nota' => $request->nota,
            'observaciones' => $request->observaciones,
            'estado' => 'observado',
        ]);

        return back()->with('success', 'Entrega calificada exitosamente.');
    }
}
