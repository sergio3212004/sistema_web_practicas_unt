<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostulacionController extends Controller
{
    //
    use AuthorizesRequests;
    public function index() {
        $empresa = auth()->user()->empresa;

        $publicaciones = Publicacion::where('empresa_id', $empresa->id)
            ->latest()
            ->get();

        return view('empresa.postulaciones.index', compact('publicaciones', 'empresa'));
    }

    public function show(Publicacion $publicacion)
    {
        $postulaciones = $publicacion->postulaciones()
            ->with(['alumno.user'])
            ->get();

        return view('empresa.postulaciones.show', compact('publicacion', 'postulaciones'));
    }

    public function aprobar(Postulacion $postulacion)
    {
        $postulacion->update([
            'aprobado' => true,
        ]);

        return back()->with('success', 'Postulación aprobada correctamente.');
    }

    public function rechazar(Postulacion $postulacion)
    {
        $postulacion->update([
            'aprobado' => false,
        ]);

        // Notificar al alumno
        $postulacion->alumno->user->notify(
            new PostulacionRechazada($postulacion)
        );

        return back()->with('error', 'Postulación rechazada y notificada al alumno.');
    }

}
