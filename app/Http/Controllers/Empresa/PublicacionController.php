<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresa = auth()->user()->empresa;

        $publicaciones = \App\Models\Publicacion::where('empresa_id', $empresa->id)
            ->latest()
            ->get();

        return view('empresa.publicaciones.index', compact('publicaciones', 'empresa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('empresa.publicaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:70',
            'cargo' => 'required|string|max:50',
            'descripcion' => 'required',
            'estado' => 'required|in:Disponible,Cubierta',
            'imagen' => 'image|max:2048'
        ]);


        $ruta = 'images/img.png';

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('publicaciones', 'public');

        }

        Publicacion::create([
            'nombre' => $request->nombre,
            'cargo' => $request->cargo,
            'empresa_id' => auth()->user()->empresa->id,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'imagen' => $ruta,
        ]);

        return redirect()->route('empresa.publicaciones.index')
            ->with('success', 'Publicación creada correctamente.');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $publicacion = \App\Models\Publicacion::findOrFail($id);

        // Asegurar que la publicación pertenece a la empresa logueada
        if ($publicacion->empresa_id !== auth()->user()->empresa->id) {
            abort(403, 'No tienes permiso para editar esta publicación.');
        }

        return view('empresa.publicaciones.edit', compact('publicacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        // Seguridad: verificar empresa
        if ($publicacion->empresa_id !== auth()->user()->empresa->id) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:70',
            'cargo' => 'required|string|max:50',
            'descripcion' => 'required',
            'estado' => 'required|in:Disponible,Cubierta',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // Si hay nueva imagen → borrar la anterior
        if ($request->hasFile('imagen')) {
            if ($publicacion->imagen && Storage::disk('public')->exists($publicacion->imagen)) {
                Storage::disk('public')->delete($publicacion->imagen);
            }

            $publicacion->imagen = $request->file('imagen')
                ->store('publicaciones', 'public');
        }

        // Actualizar campos
        $publicacion->fill([
            'nombre' => $request->nombre,
            'cargo' => $request->cargo,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
        ]);

        // Guarda y actualiza updated_at automáticamente
        $publicacion->save();

        return redirect()
            ->route('empresa.publicaciones.index')
            ->with('success', 'Publicación actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $publicacion = Publicacion::findOrFail($id);

        // Verificar que pertenece a la empresa logueada
        if ($publicacion->empresa_id !== auth()->user()->empresa->id) {
            abort(403, 'No tienes permiso para eliminar esta publicación.');
        }

        // Eliminar la imagen del disco si existe
        if ($publicacion->imagen && \Storage::disk('public')->exists($publicacion->imagen)) {
            \Storage::disk('public')->delete($publicacion->imagen);
        }

        // Eliminar la publicación
        $publicacion->delete();

        return redirect()
            ->route('empresa.publicaciones.index')
            ->with('success', 'Publicación eliminada correctamente.');
    }
}
