<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\FirmaToken;
use Illuminate\Http\Request;

class FirmaCronogramaController extends Controller
{
    /**
     * Muestra la página para firmar con token
     */
    public function show($token)
    {
        $firmaToken = FirmaToken::where('token', $token)
            ->where('contexto', 'cronograma')
            ->firstOrFail();

        // Verificar si el token está vencido
        if ($firmaToken->estaVencido()) {
            return view('firma.vencido', compact('firmaToken'));
        }

        // Verificar si ya está firmado
        if ($firmaToken->estaFirmado()) {
            return view('firma.ya-firmado', compact('firmaToken'));
        }

        // Cargar el cronograma con sus relaciones
        $cronograma = $firmaToken->cronograma;
        $cronograma->load([
            'fichaRegistro.alumno',
            'fichaRegistro.horarios',
            'actividades'
        ]);

        return view('firma.cronograma', compact('firmaToken', 'cronograma'));
    }

    /**
     * Procesa la firma
     */
    public function firmar(Request $request, $token)
    {
        $request->validate([
            'firma' => 'required|string',
            'acepto' => 'required|accepted'
        ]);

        $firmaToken = FirmaToken::where('token', $token)
            ->where('contexto', 'cronograma')
            ->firstOrFail();

        // Verificaciones
        if ($firmaToken->estaVencido()) {
            return redirect()->route('firma.cronograma', $token)
                ->with('error', 'El token ha expirado.');
        }

        if ($firmaToken->estaFirmado()) {
            return redirect()->route('firma.cronograma', $token)
                ->with('info', 'Este documento ya ha sido firmado.');
        }

        try {
            // Actualizar el token
            $firmaToken->update([
                'signed_at' => now()
            ]);

            // Actualizar el cronograma según el tipo de firma
            $cronograma = $firmaToken->cronograma;

            if ($firmaToken->tipo === 'jefe_directo') {
                $cronograma->update(['firma_jefe_directo_at' => now()]);
            } elseif ($firmaToken->tipo === 'profesor') {
                $cronograma->update(['firma_profesor_at' => now()]);
            }

            // Guardar la firma como imagen (opcional)
            $this->guardarFirmaToken($request->firma, $firmaToken->tipo, $cronograma->id);

            return view('firma.confirmacion', [
                'cronograma' => $cronograma,
                'tipo' => $firmaToken->tipo
            ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al procesar la firma: ' . $e->getMessage());
        }
    }

    /**
     * Guarda la firma como imagen
     */
    private function guardarFirmaToken($base64Data, $tipo, $cronogramaId)
    {
        $image = str_replace('data:image/png;base64,', '', $base64Data);
        $image = str_replace(' ', '+', $image);
        $imageName = "firma_{$tipo}_{$cronogramaId}_" . time() . '.png';

        $path = storage_path('app/public/firmas/cronogramas/');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . $imageName, base64_decode($image));

        return 'firmas/cronogramas/' . $imageName;
    }
}
