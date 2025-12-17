<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmpresaAprobada
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Si es empresa, verificar que esté aprobada
        if ($user && $user->rol && $user->rol->nombre === 'empresa') {
            $empresa = $user->empresa;

            if (!$empresa || !$empresa->aprobado) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Tu cuenta está pendiente de aprobación por el administrador.']);
            }
        }

        return $next($request);
    }
}
