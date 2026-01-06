<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <x-heroicon-o-briefcase class="h-8 w-8 text-indigo-600"/>
                Prácticas disponibles
            </h1>
            <p class="text-gray-500 mt-1">
                Explora las convocatorias de prácticas preprofesionales
            </p>
        </div>

        {{-- Si no hay prácticas --}}
        @if($practicas->isEmpty())
            <div class="bg-gray-100 text-gray-600 p-8 rounded-xl text-center shadow">
                No hay prácticas disponibles en este momento.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($practicas as $practica)
                    <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">

                        {{-- Encabezado --}}
                        <div class="bg-gradient-to-br from-indigo-800 to-blue-900 px-6 py-4">
                            <h2 class="text-lg font-bold text-white">
                                {{ $practica->cargo }}
                            </h2>
                            <p class="text-indigo-200 text-sm">
                                {{ $practica->empresa->nombre ?? 'Empresa no disponible' }}
                            </p>
                        </div>

                        {{-- Contenido --}}
                        <div class="p-6 space-y-4">

                            {{-- Estado y fecha --}}
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $practica->estado === 'Cubierta'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-green-100 text-green-800' }}">
                                    {{ $practica->estado }}
                                </span>

                                <span class="text-xs text-gray-400">
                                    {{ $practica->created_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Título --}}
                            <h3 class="text-lg font-semibold text-gray-700">
                                {{ $practica->nombre }}
                            </h3>

                            {{-- Descripción --}}
                            <p class="text-gray-600 text-sm line-clamp-3">
                                {{ $practica->descripcion }}
                            </p>

                            {{-- Imagen --}}
                            @if($practica->imagen)
                                <img src="{{ asset('storage/' . $practica->imagen) }}"
                                     class="w-full h-36 object-cover rounded-xl shadow-sm">
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <a href="{{ route('alumno.practicas.show', $practica->id) }}"
                               class="block text-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-semibold rounded-lg shadow hover:from-indigo-600 hover:to-blue-600 transition">
                                Ver detalle
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
