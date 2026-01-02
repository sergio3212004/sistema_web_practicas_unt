<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Cronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CronogramaController extends Controller
{
    //
    public function show(Cronograma $cronograma)
    {
        // Seguridad: el cronograma debe pertenecer a un alumno del aula del profesor
        $profesor = Auth::user()->profesor;

        abort_if(
            $cronograma->fichaRegistro->alumno->aula->profesor_id !== $profesor->id,
            403
        );

        return view('profesor.cronogramas.show', compact('cronograma'));
    }

    /**
     * Guardar firma del profesor
     */
    public function firmar(Request $request, Cronograma $cronograma)
    {
        $request->validate([
            'firma' => 'required|string'
        ]);

        // Ya firmado → no permitir doble firma
        if ($cronograma->firma_profesor) {
            return back()->with('error', 'Este cronograma ya fue firmado.');
        }

        // Decodificar imagen base64
        $firmaBase64 = $request->firma;
        $firmaBase64 = str_replace('data:image/png;base64,', '', $firmaBase64);
        $firmaBase64 = str_replace(' ', '+', $firmaBase64);

        $nombreArchivo = 'firma_profesor_' . Str::uuid() . '.png';
        $ruta = 'firmas/cronogramas/' . $nombreArchivo;

        Storage::disk('public')->put($ruta, base64_decode($firmaBase64));

        // Guardar firma
        $cronograma->update([
            'firma_profesor' => $ruta
        ]);

        return redirect()
            ->route('profesor.cronogramas.show', $cronograma)
            ->with('success', 'Cronograma firmado correctamente.');
    }

}
