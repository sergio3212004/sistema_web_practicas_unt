<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <x-heroicon-o-briefcase class="h-8 w-8 text-indigo-600"/>
                    {{ $practica->nombre }}
                </h1>
                <p class="text-gray-500 mt-1">
                    {{ $practica->cargo }}
                </p>
            </div>

            <a href="{{ route('alumno.practicas.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                Volver
            </a>
        </div>

        {{-- Card principal --}}
        <div class="relative mb-10">
            <!-- Glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-20"></div>

            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Imagen --}}
                @if($practica->imagen)
                    <img src="{{ asset('storage/' . $practica->imagen) }}"
                         class="w-full max-h-96 object-cover">
                @endif

                {{-- Contenido --}}
                <div class="p-8 space-y-6">

                    {{-- Estado y fecha --}}
                    <div class="flex items-center justify-between">
                        <span class="px-4 py-1 text-sm font-semibold rounded-full
                            {{ $practica->estado === 'Cubierta'
                                ? 'bg-red-100 text-red-800'
                                : 'bg-green-100 text-green-800' }}">
                            {{ $practica->estado }}
                        </span>

                        <span class="text-sm text-gray-400">
                            Publicado {{ $practica->created_at->diffForHumans(['parts' => 2]) }}
                        </span>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            Descripción de la práctica
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $practica->descripcion }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Información de la empresa --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Empresa --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <x-heroicon-o-building-office class="h-6 w-6 text-indigo-600"/>
                    Empresa
                </h3>

                <div class="space-y-2 text-gray-700">
                    <p><strong>Nombre:</strong> {{ $practica->empresa->nombre }}  {{ $practica->empresa->razonSocial->acronimo }}</p>

                    <p>
                        <strong>Ubicación:</strong>
                        {{ $practica->empresa->departamento }},
                        {{ $practica->empresa->provincia }},
                        {{ $practica->empresa->distrito }}
                    </p>
                </div>
            </div>

            {{-- Contacto --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <x-heroicon-o-phone class="h-6 w-6 text-indigo-600"/>
                    Contacto
                </h3>

                <div class="space-y-2 text-gray-700">
                    <p>
                        <strong>Teléfono:</strong>
                        {{ $practica->empresa->telefono ?? 'No disponible' }}
                    </p>

                    <p>
                        <strong>Correo:</strong>
                        {{ $practica->empresa->user->email ?? 'No disponible' }}
                    </p>

                    <p>
                        <strong>Dirección:</strong>
                        {{ $practica->empresa->direccion ?? 'No disponible' }}
                    </p>
                </div>
            </div>

        </div>

        {{-- CTA --}}
        <div class="mt-10 text-center">
            <a href="{{route('alumno.practicas.postular', $practica)}}"
               class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                <x-heroicon-o-paper-airplane class="h-6 w-6"/>
                Postular a esta práctica
            </a>

        </div>

    </div>
</x-app-layout>
