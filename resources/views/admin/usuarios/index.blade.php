<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl">

        <!-- Título y botón -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Listado de Usuarios</h1>
            <a href="{{ route('admin.usuarios.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                + Nuevo Usuario
            </a>
        </div>

        <!-- Mensajes -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Nombre</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Rol</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Acciones</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition">

                        <!-- Email -->
                        <td class="px-4 py-3 text-sm text-gray-800">
                            {{ $user->email }}
                        </td>

                        <!-- Nombre -->
                        <td class="px-4 py-3 text-sm text-gray-900">
                            @if ($user->rol->nombre === 'empresa' && $user->empresa)
                                {{ $user->empresa->nombre }} ({{ $user->empresa->razonSocial->acronimo ?? '' }})
                            @elseif ($user->rol->nombre === 'administrador')
                                {{ $user->administrador->nombres ?? '—' }}
                                {{ $user->administrador->apellido_paterno ?? '' }}
                            @elseif ($user->rol->nombre === 'alumno')
                                {{ $user->alumno->nombres ?? '—' }}
                                {{ $user->alumno->apellido_paterno ?? '' }}
                            @elseif ($user->rol->nombre === 'profesor')
                                {{ $user->profesor->nombres ?? '-' }}
                                {{ $user->profesor->apellido_paterno ?? '' }}
                            @else
                                <span class="italic text-gray-400">Sin perfil</span>
                            @endif
                        </td>

                        <!-- Rol -->
                        <td class="px-4 py-3 text-sm text-gray-800 capitalize">
                            {{ $user->rol->nombre }}
                        </td>

                        <!-- Acciones -->
                        <td class="px-4 py-3 text-sm text-center">
                            <div class="flex justify-center gap-2">

                                <!-- Ver -->
                                <a href="{{ route('admin.usuarios.show', $user->id) }}"
                                   class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 text-sm">
                                    Ver
                                </a>

                                <!-- Editar -->
                                <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                                   class="px-3 py-1 text-white bg-indigo-600 rounded hover:bg-indigo-700 text-sm">
                                    Editar
                                </a>

                                <!-- Eliminar -->
                                <form action="{{ route('admin.usuarios.destroy', $user->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
