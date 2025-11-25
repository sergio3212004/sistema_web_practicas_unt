<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $usuarios = User::with('rol')->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $roles = Rol::all();

        return view('admin.usuarios.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación base
        $rules = [
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'rol_id'    => 'required|exists:roles,id',
        ];

        // Validación condicional según el rol
        if ($request->rol_id == 1) { // Alumno
            $rules['codigo_matricula'] = 'required|string|max:255';
            $rules['nombres'] = 'required|string|max:255';
            $rules['apellido_paterno'] = 'required|string|max:255';
            $rules['apellido_materno'] = 'nullable|string|max:255';
            $rules['telefono'] = 'nullable|string|max:20';
        }

        if ($request->rol_id == 5) { // Administrador
            $rules['nombres'] = 'required|string|max:255';
            $rules['apellido_paterno'] = 'required|string|max:255';
            $rules['apellido_materno'] = 'nullable|string|max:255';
            $rules['telefono'] = 'nullable|string|max:20';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            // 1. Crear el usuario
            $usuario = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'rol_id'   => $request->rol_id,
            ]);

            // 2. Crear registros extra según el rol
            if ($usuario->rol_id == 1) {  // Alumno
                $usuario->alumno()->create([
                    'codigo_matricula'  => $request->codigo_matricula,
                    'nombres'           => $request->nombres,
                    'apellido_paterno'  => $request->apellido_paterno,
                    'apellido_materno'  => $request->apellido_materno,
                    'telefono'          => $request->telefono,
                ]);
            }

            if ($usuario->rol_id == 5) { // Administrador
                $usuario->administrador()->create([
                    'nombres'           => $request->nombres,
                    'apellido_paterno'  => $request->apellido_paterno,
                    'apellido_materno'  => $request->apellido_materno,
                    'telefono'          => $request->telefono,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.usuarios.index')
                ->with('success', 'Usuario registrado correctamente.');

        } catch (\Throwable $th) {
            DB::rollback();

            // Logging para debug
            \Log::error('Error al crear usuario: ' . $th->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al guardar: ' . $th->getMessage()]);
        }
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
