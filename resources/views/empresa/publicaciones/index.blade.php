<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <x-heroicon-o-newspaper class="h-8 w-8 text-indigo-600"/>
                Publicaciones de Practicantes
            </h1>

            <a href="{{ route('empresa.publicaciones.create') }}"
               class="px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                Nueva Publicación
            </a>
        </div>

        @php
            $empresa = auth()->user()->empresa ?? null;
            $publicaciones = $empresa ? \App\Models\Publicacion::where('empresa_id', $empresa->id)->latest()->get() : collect();
        @endphp

        {{-- Si no hay empresa --}}
        @if(!$empresa)
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl shadow text-center">
                No tienes una empresa asociada. Por favor registra tu empresa para gestionar publicaciones.
            </div>
        @elseif($publicaciones->isEmpty())
            {{-- Si no hay publicaciones --}}
            <div class="bg-gray-100 text-gray-600 p-8 rounded-xl text-center shadow">
                No hay publicaciones registradas.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($publicaciones as $publicacion)
                    <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">
                        {{-- Encabezado con gradiente y cargo --}}
                        <div class="bg-gradient-to-br from-blue-800 to-indigo-900 px-6 py-4">
                            <h2 class="text-xl font-bold text-white">{{ $publicacion->cargo ?? 'Cargo no especificado' }}</h2>
                        </div>

                        {{-- Contenido --}}
                        <div class="p-6 space-y-4">
                            {{-- Estado --}}
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $publicacion->estado === 'Cubierta'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-green-100 text-green-800' }}">
                                    {{ $publicacion->estado ?? 'Disponible' }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    Creado: {{ $publicacion->created_at->diffForHumans(['parts'=>2]) }}
                                </span>
                            </div>

                            {{-- Nombre / descripción --}}
                            <h3 class="text-lg font-semibold text-gray-700">{{ $publicacion->nombre }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-3">{{ $publicacion->descripcion }}</p>

                            {{-- Imagen --}}
                            @if($publicacion->imagen)
                                <img src="{{ asset('storage/'.$publicacion->imagen) }}"
                                     class="w-full h-36 object-cover rounded-xl mt-2 shadow-sm">
                            @endif
                        </div>

                        {{-- Footer con acciones --}}
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between gap-2">
                            <a href="{{ route('empresa.publicaciones.edit', $publicacion->id) }}"
                               class="flex-1 text-center px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-medium rounded-lg shadow hover:from-blue-600 hover:to-indigo-600 transition">
                                Editar
                            </a>

                            <form action="{{ route('empresa.publicaciones.destroy', $publicacion->id) }}" method="POST" class="flex-1"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta publicación?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full px-3 py-2 bg-red-500 text-white font-medium rounded-lg shadow hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
