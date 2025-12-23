<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCodigoFicha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('codigo_ficha_validado')) {
            return redirect()
                ->route('alumno.ficha.codigo')
                ->with('error', 'Debes verificar el código antes de crear una ficha.');
        }

        return $next($request);
    }
}
