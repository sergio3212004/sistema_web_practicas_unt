<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('empresa.publicaciones.index');
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
        //
        $request->validate([
            'nombre' => 'required|string|max:70',
            'descripcion' => 'required',
            'fecha' => 'required|date',
            'imagen' => 'required|image|max:2048'
        ]);

        $ruta = $request->file('imagen')->store('publicaciones', 'public');

        Publicacion::create([
            'nombre' => $request->nombre,
            'empresa_id' => auth()->user()->empresa->id,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
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
        $publicacion = \App\Models\Publicacion::findOrFail($id);

        if ($publicacion->empresa_id !== auth()->user()->empresa->id) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'nombre' => 'required|string|max:70',
            'descripcion' => 'required',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // Guardar ruta actual por si hay que borrar
        $imagenAnterior = $publicacion->imagen;

        // Si se subió una nueva imagen
        if ($request->hasFile('imagen')) {

            // Borrar la imagen anterior del storage
            if ($imagenAnterior && \Storage::disk('public')->exists($imagenAnterior)) {
                \Storage::disk('public')->delete($imagenAnterior);
            }

            // Subir la nueva
            $publicacion->imagen = $request->file('imagen')->store('publicaciones', 'public');
        }

        // Actualizar campos restantes
        $publicacion->nombre = $request->nombre;
        $publicacion->descripcion = $request->descripcion;
        $publicacion->fecha = $request->fecha;

        // Guardar cambios
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
