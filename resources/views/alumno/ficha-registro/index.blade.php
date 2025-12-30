<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ficha de Registro
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-8 text-center">

                @if(!$ficha)
                    {{-- NO EXISTE FICHA --}}
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                        Aún no has registrado tu ficha
                    </h3>

                    <p class="text-sm text-gray-500 mb-6">
                        Debes registrar tu ficha de prácticas pre profesionales.
                    </p>

                    <a href="{{ route('alumno.ficha.create') }}"
                       class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Registrar Ficha
                    </a>
                @else
                    {{-- EXISTE FICHA --}}
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Tu ficha de registro
                    </h3>

                    <p class="text-sm text-gray-500 mb-2">
                        Empresa: <strong>{{ $ficha->razon_social }}</strong>
                    </p>

                    <p class="mb-6">
                        Estado:
                        @if($ficha->aceptado)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                Aceptada
            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                En revisión
            </span>
                        @endif
                    </p>

                    {{-- ACCIONES --}}
                    <div class="flex justify-center gap-4 flex-wrap">

                        {{-- VER FICHA --}}
                        <a href="{{ route('alumno.ficha.show', $ficha) }}"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg
                  hover:bg-blue-700 transition">
                            Ver Ficha
                        </a>

                        {{-- CRONOGRAMA --}}
                        @if(!$ficha->cronograma)
                            <a href="{{ route('alumno.cronograma.create', $ficha) }}"
                               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg
                      hover:bg-indigo-700 transition">
                                Crear Cronograma
                            </a>
                        @else
                            <a href="{{ route('alumno.cronograma.show', $ficha->cronograma) }}"
                               class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg
                      hover:bg-emerald-700 transition">
                                Ver Cronograma
                            </a>
                        @endif

                    </div>
                @endif


            </div>

        </div>
    </div>
</x-app-layout>
