<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Lista de Usuarios
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-300 rounded text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Usuarios Registrados</h3>

                    <a href="{{ route('admin.usuarios.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        + Nuevo Usuario
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Nombre</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Email</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Rol</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-gray-700">{{ $usuario->name }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $usuario->email }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-3 py-1 bg-gray-200 rounded text-gray-700 text-sm">
                                        {{ $usuario->rol->nombre }}
                                    </span>
                                </td>

                                <td class="px-6 py-3 text-right">

                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium mr-3">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"
                                                class="text-red-600 hover:text-red-800 font-medium">
                                            Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $usuarios->links() }}
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
