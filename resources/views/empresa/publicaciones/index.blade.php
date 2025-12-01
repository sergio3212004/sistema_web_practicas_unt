<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <x-heroicon-o-newspaper class="h-7 w-7 text-indigo-600"/>
                Publicaciones
            </h1>

            <a href="{{ route('empresa.publicaciones.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                Nueva Publicación
            </a>
        </div>

        @php
            $publicaciones = \App\Models\Publicacion::where('empresa_id', auth()->user()->empresa->id)->get();
        @endphp

            <!-- Si no hay publicaciones -->
        @if($publicaciones->isEmpty())
            <div class="bg-gray-100 text-gray-600 p-6 rounded-lg text-center">
                No hay publicaciones registradas.
            </div>
        @else
            <!-- Tabla -->
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-gray-700">Fecha</th>
                        <th class="px-4 py-2 text-left text-gray-700">Imagen</th>
                        <th class="px-4 py-2 text-center text-gray-700">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($publicaciones as $publicacion)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $publicacion->nombre }}</td>
                            <td class="px-4 py-2">{{ $publicacion->fecha }}</td>
                            <td class="px-4 py-2">
                                @if($publicacion->imagen)
                                    <img src="{{ asset('storage/'.$publicacion->imagen) }}"
                                         class="h-12 rounded">
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center flex justify-center gap-2">
                                <a href="{{ route('empresa.publicaciones.edit', $publicacion->id) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Editar
                                </a>

                                <form action="{{ route('empresa.publicaciones.destroy', $publicacion->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta publicación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</x-app-layout>
