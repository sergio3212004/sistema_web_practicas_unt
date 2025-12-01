<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\RazonSocial;
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
        // Precarga las relaciones 'rol', 'alumno' y 'administrador'
        $users = User::with('rol', 'alumno', 'administrador', 'empresa', 'profesor')->paginate(10);
        return view('admin.usuarios.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Rol::all();
        // Nota: Asume que tienes IDs fijos para los roles o utiliza el nombre:
        // $rolAdminId = $roles->firstWhere('nombre', 'Administrador')?->id;
        // $rolAlumnoId = $roles->firstWhere('nombre', 'Alumno')?->id;
        $razonesSociales = RazonSocial::all();
        return view('admin.usuarios.create', compact('roles', 'razonesSociales'));

    }

    /**
     * Almacena un nuevo usuario y su perfil asociado en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar datos básicos del usuario
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $rol = Rol::findOrFail($request->rol_id);

        // 2. Validar campos específicos del perfil (Administrador o Alumno)
        if ($rol->nombre === 'administrador') {
            $request->validate([
                'nombres_admin' => 'required|string|max:255',
                'apellido_paterno_admin' => 'required|string|max:255',
                'apellido_materno_admin' => 'required|string|max:255',
                'telefono_admin' => 'nullable|string|max:20',
            ]);
        } elseif ($rol->nombre === 'alumno') {
            $request->validate([
                'codigo_matricula_alumno' => 'required|string|unique:alumnos,codigo_matricula|max:50',
                'nombres_alumno' => 'required|string|max:255',
                'apellido_paterno_alumno' => 'required|string|max:255',
                'apellido_materno_alumno' => 'required|string|max:255',
                'telefono_alumno' => 'nullable|string|max:20',
            ]);
        } elseif ($rol->nombre === 'empresa') {
            $request->validate([
                'ruc' => 'required|string|max:11|unique:empresas,ruc',
                'nombre' => 'required|string|max:255',
                'razon_social_id' => 'required|exists:razones_sociales,id',
                'telefono' => 'nullable|string|max:9',
                'departamento' => 'required|string',
                'provincia' => 'required|string',
                'distrito' => 'required|string',
                'direccion' => 'required|string|max:255',
            ]);
        } elseif ($rol->nombre === 'profesor') {
            $request->validate([
                'codigo_profesor' => 'required|string|max:50|unique:profesores,codigo_profesor',
                'nombres_profesor' => 'required|string|max:255',
                'apellido_paterno_profesor' => 'required|string|max:255',
                'apellido_materno_profesor' => 'required|string|max:255',
                'telefono_profesor' => 'nullable|string|max:20',
            ]);
        }

        // 3. Crear el Usuario
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);

        // 4. Crear el perfil asociado (Administrador o Alumno)
        if ($rol->nombre === 'administrador') {
            $user->administrador()->create([
                'nombres' => $request->nombres_admin,
                'apellido_paterno' => $request->apellido_paterno_admin,
                'apellido_materno' => $request->apellido_materno_admin,
                'telefono' => $request->telefono_admin,
            ]);
        } elseif ($rol->nombre === 'alumno') {
            $user->alumno()->create([
                'codigo_matricula' => $request->codigo_matricula_alumno,
                'nombres' => $request->nombres_alumno,
                'apellido_paterno' => $request->apellido_paterno_alumno,
                'apellido_materno' => $request->apellido_materno_alumno,
                'telefono' => $request->telefono_alumno,
            ]);
        } elseif ($rol->nombre === 'empresa') {
            $user->empresa()->create([
                'ruc' => $request->ruc,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'razon_social_id' => $request->razon_social_id,
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'direccion' => $request->direccion,
            ]);
        } elseif ($rol->nombre === 'profesor') {
            $user->profesor()->create([
                'codigo_profesor'   => $request->codigo_profesor,
                'nombres'           => $request->nombres_profesor,
                'apellido_paterno'  => $request->apellido_paterno_profesor,
                'apellido_materno'  => $request->apellido_materno_profesor,
                'telefono'          => $request->telefono_profesor,
            ]);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario y perfil asociados creados exitosamente.');
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show(User $usuario)
    {
        // Precarga las relaciones para mostrar los datos del perfil
        $usuario->load('rol', 'alumno', 'administrador', 'profesor');
        $razonesSociales = RazonSocial::all();
        return view('admin.usuarios.show', compact('usuario', 'razonesSociales'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $usuario = User::with('rol', 'alumno', 'administrador', 'profesor')->findOrFail($id);
        $roles = Rol::all();
        $razonesSociales = RazonSocial::all();

        return view('admin.usuarios.edit', compact('usuario', 'roles', 'razonesSociales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::with('rol', 'alumno', 'administrador')->findOrFail($id);

        // Validación base
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'rol_id' => 'required|exists:roles,id',
        ]);

        $rol = Rol::findOrFail($request->rol_id);

        // Validaciones según el rol
        if ($rol->nombre === 'administrador') {
            $request->validate([
                'nombres_admin' => 'required|string|max:255',
                'apellido_paterno_admin' => 'required|string|max:255',
                'apellido_materno_admin' => 'required|string|max:255',
                'telefono_admin' => 'nullable|string|max:20',
            ]);
        } elseif ($rol->nombre === 'alumno') {
            $request->validate([
                'codigo_matricula_alumno' => 'required|string|max:50|unique:alumnos,codigo_matricula,' . ($user->alumno->id ?? 'null'),
                'nombres_alumno' => 'required|string|max:255',
                'apellido_paterno_alumno' => 'required|string|max:255',
                'apellido_materno_alumno' => 'required|string|max:255',
                'telefono_alumno' => 'nullable|string|max:20',
            ]);
        } elseif ($rol->nombre === 'empresa') {
            $request->validate([
                'ruc' => 'required|string|max:11|unique:empresas,ruc,' . ($user->empresa->id ?? 'null'),
                'nombre' => 'required|string|max:255',
                'razon_social_id' => 'required|exists:razones_sociales,id',
                'telefono' => 'nullable|string|max:20',
                'departamento' => 'required|string',
                'provincia' => 'required|string',
                'distrito' => 'required|string',
                'direccion' => 'required|string|max:255',
            ]);
        } elseif ($rol->nombre === 'profesor') {
            $request->validate([
                'codigo_profesor' => 'required|string|max:50|unique:profesores,codigo_profesor,' . ($user->profesor->id ?? 'null'),
                'nombres_profesor' => 'required|string|max:255',
                'apellido_paterno_profesor' => 'required|string|max:255',
                'apellido_materno_profesor' => 'required|string|max:255',
                'telefono_profesor' => 'nullable|string|max:20',
            ]);
        }

        // Update Usuario
        $user->update([
            'email' => $request->email,
            'rol_id' => $request->rol_id,
        ]);

        // Si cambió de rol → eliminar perfil anterior
        if ($user->rol->nombre !== $rol->nombre) {
            if ($user->administrador) $user->administrador->delete();
            if ($user->alumno) $user->alumno->delete();
        }

        // Actualizar o crear perfil adecuado
        if ($rol->nombre === 'administrador') {
            $user->administrador()->updateOrCreate([], [
                'nombres' => $request->nombres_admin,
                'apellido_paterno' => $request->apellido_paterno_admin,
                'apellido_materno' => $request->apellido_materno_admin,
                'telefono' => $request->telefono_admin,
            ]);
        }

        if ($rol->nombre === 'alumno') {
            $user->alumno()->updateOrCreate([], [
                'codigo_matricula' => $request->codigo_matricula_alumno,
                'nombres' => $request->nombres_alumno,
                'apellido_paterno' => $request->apellido_paterno_alumno,
                'apellido_materno' => $request->apellido_materno_alumno,
                'telefono' => $request->telefono_alumno,
            ]);
        }

        if ($rol->nombre === 'empresa') {
            $user->empresa()->updateOrCreate([], [
                'ruc' => $request->ruc,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'razon_social_id' => $request->razon_social_id,
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'direccion' => $request->direccion,
            ]);
        }

        if ($rol->nombre === 'profesor') {
            $user->profesor()->updateOrCreate([], [
                'codigo_profesor'   => $request->codigo_profesor,
                'nombres'           => $request->nombres_profesor,
                'apellido_paterno'  => $request->apellido_paterno_profesor,
                'apellido_materno'  => $request->apellido_materno_profesor,
                'telefono'          => $request->telefono_profesor,
            ]);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::with('alumno', 'administrador', 'empresa', 'profesor')->findOrFail($id);

        // Borrar perfiles relacionados
        if ($user->administrador) $user->administrador->delete();
        if ($user->alumno) $user->alumno->delete();
        if ($user->empresa) $user->empresa->delete();
        if ($user->profesor) $user->profesor->delete();

        // Borrar usuario
        $user->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
