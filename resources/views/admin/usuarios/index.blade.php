<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Encabezado con gradiente institucional -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 rounded-2xl shadow-lg p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">
                            Gestión de Usuarios
                        </h1>
                        <p class="text-blue-100 text-sm">
                            Administración institucional de usuarios del sistema
                        </p>
                    </div>

                    <a href="{{ route('admin.usuarios.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-800 text-sm font-semibold rounded-lg shadow-md hover:bg-blue-50 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Nuevo usuario
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Usuarios</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Alumnos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('rol.nombre', 'alumno')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Empresas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('rol.nombre', 'empresa')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Profesores</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('rol.nombre', 'profesor')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            <!-- Header de la tabla -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Lista de Usuarios</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Nombre Completo
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-150">

                            <!-- Email -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->email, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Nombre -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    @if ($user->rol->nombre === 'empresa' && $user->empresa)
                                        {{ $user->empresa->nombre }}
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            {{ $user->empresa->razonSocial->acronimo ?? '' }}
                                        </span>
                                    @elseif ($user->rol->nombre === 'administrador')
                                        {{ $user->administrador->nombres ?? '—' }}
                                        {{ $user->administrador->apellido_paterno ?? '' }}
                                    @elseif ($user->rol->nombre === 'alumno')
                                        {{ $user->alumno->nombres ?? '—' }}
                                        {{ $user->alumno->apellido_paterno ?? '' }}
                                    @elseif ($user->rol->nombre === 'profesor')
                                        {{ $user->profesor->nombres ?? '—' }}
                                        {{ $user->profesor->apellido_paterno ?? '' }}
                                    @else
                                        <span class="italic text-gray-400">Sin perfil asignado</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Rol -->
                            <td class="px-6 py-4">
                                @php
                                    $rolColors = [
                                        'administrador' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'alumno' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'profesor' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        'empresa' => 'bg-green-100 text-green-800 border-green-200',
                                    ];
                                    $colorClass = $rolColors[$user->rol->nombre] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }} capitalize">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5"></span>
                                    {{ $user->rol->nombre }}
                                </span>
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">

                                    <!-- Ver -->
                                    <a href="{{ route('admin.usuarios.show', $user->id) }}"
                                       class="inline-flex items-center p-2 rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:shadow-md transform hover:scale-105 transition-all duration-200"
                                       title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                  c4.478 0 8.268 2.943 9.542 7
                                                  -1.274 4.057-5.064 7-9.542 7
                                                  -4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <!-- Editar -->
                                    <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                                       class="inline-flex items-center p-2 rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 hover:shadow-md transform hover:scale-105 transition-all duration-200"
                                       title="Editar usuario">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Está seguro que desea eliminar este usuario? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center p-2 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:shadow-md transform hover:scale-105 transition-all duration-200"
                                                title="Eliminar usuario">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Footer de la tabla -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Mostrando <span class="font-medium text-gray-900">{{ $users->firstItem() }}</span>
                        a <span class="font-medium text-gray-900">{{ $users->lastItem() }}</span>
                        de <span class="font-medium text-gray-900">{{ $users->total() }}</span> usuarios
                    </div>
                </div>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
