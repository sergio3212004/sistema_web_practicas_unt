<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl my-4 sm:my-8">

        <!-- Título -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Detalles del Usuario</h1>
            <a href="{{ route('admin.usuarios.index') }}"
               class="text-indigo-600 hover:text-indigo-900">&larr; Volver</a>
        </div>

        <!-- Datos del Usuario -->
        <div class="mb-8 p-6 bg-indigo-50 rounded-lg border border-indigo-200">
            <h2 class="text-xl font-semibold text-indigo-700 border-b pb-2 mb-4">Datos del Usuario</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="font-semibold text-gray-700">Email</p>
                    <p class="text-gray-900">{{ $usuario->email }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-700">Rol</p>
                    <p class="text-gray-900 capitalize">{{ $usuario->rol->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Datos del Perfil -->
        <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-300">
            <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">
                Perfil ({{ ucfirst($usuario->rol->nombre) }})
            </h2>

            @if ($usuario->rol->nombre === 'administrador')
                <div class="space-y-2">
                    <p><span class="font-semibold">Nombres:</span> {{ $usuario->administrador->nombres }}</p>
                    <p><span class="font-semibold">Apellido Paterno:</span> {{ $usuario->administrador->apellido_paterno }}</p>
                    <p><span class="font-semibold">Apellido Materno:</span> {{ $usuario->administrador->apellido_materno }}</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ $usuario->administrador->telefono ?? '—' }}</p>
                </div>

            @elseif ($usuario->rol->nombre === 'alumno')
                <div class="space-y-2">
                    <p><span class="font-semibold">Código Matrícula:</span> {{ $usuario->alumno->codigo_matricula }}</p>
                    <p><span class="font-semibold">Nombres:</span> {{ $usuario->alumno->nombres }}</p>
                    <p><span class="font-semibold">Apellido Paterno:</span> {{ $usuario->alumno->apellido_paterno }}</p>
                    <p><span class="font-semibold">Apellido Materno:</span> {{ $usuario->alumno->apellido_materno }}</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ $usuario->alumno->telefono ?? '—' }}</p>
                </div>

            @elseif ($usuario->rol->nombre === 'empresa')
                <div class="space-y-2">
                    <p><span class="font-semibold">RUC:</span> {{ $usuario->empresa->ruc }}</p>
                    <p><span class="font-semibold">Nombre Comercial:</span> {{ $usuario->empresa->nombre }}</p>
                    <p><span class="font-semibold">Razón Social:</span> {{ $usuario->empresa->razonSocial->acronimo ?? '—' }}</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ $usuario->empresa->telefono ?? '—' }}</p>

                    <hr class="my-4">

                    <p><span class="font-semibold">Departamento:</span> {{ $usuario->empresa->departamento }}</p>
                    <p><span class="font-semibold">Provincia:</span> {{ $usuario->empresa->provincia }}</p>
                    <p><span class="font-semibold">Distrito:</span> {{ $usuario->empresa->distrito }}</p>
                    <p><span class="font-semibold">Dirección:</span> {{ $usuario->empresa->direccion }}</p>
                </div>
            @elseif ($usuario->rol->nombre === 'profesor')
                <div class="space-y-2">
                    <p><span class="font-semibold">Código Profesor:</span> {{ $usuario->profesor->codigo_profesor }}</p>
                    <p><span class="font-semibold">Nombres:</span> {{ $usuario->profesor->nombres }}</p>
                    <p><span class="font-semibold">Apellido Paterno:</span> {{ $usuario->profesor->apellido_paterno }}</p>
                    <p><span class="font-semibold">Apellido Materno:</span> {{ $usuario->profesor->apellido_materno }}</p>
                    <p><span class="font-semibold">Teléfono:</span> {{ $usuario->profesor->telefono ?? '—' }}</p>
                </div>
            @else
                <p class="text-gray-600">Este rol no tiene un perfil asociado.</p>
            @endif
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                Editar
            </a>

            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                  method="POST"
                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow">
                    Eliminar
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
