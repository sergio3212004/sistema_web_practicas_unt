<x-app-layout>

    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- Encabezado --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="text-3xl font-bold text-gray-800">
                Aula #{{ $aula->numero }}
            </h3>
            <p class="text-gray-500 mt-1">
                📘 Semestre: {{ $aula->semestre->nombre }}
            </p>
        </div>

        {{-- Acciones --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">

            {{-- Crear entrega --}}
            <a href="{{ route('profesor.entregas.create', ['aula_id' => $aula->id]) }}"
               class="group bg-blue-600 text-white p-6 rounded-xl shadow hover:bg-blue-700 transition">

                <h4 class="text-lg font-semibold mb-1">
                    ➕ Nueva entrega
                </h4>
                <p class="text-sm text-blue-100">
                    Asignar una tarea a esta aula
                </p>

                <span class="block mt-4 text-sm font-semibold opacity-90 group-hover:opacity-100">
                    Crear →
                </span>
            </a>

            {{-- Ver entregas --}}
            <a href="{{ route('profesor.entregas.index', ['aula_id' => $aula->id]) }}"
               class="group bg-green-600 text-white p-6 rounded-xl shadow hover:bg-green-700 transition">

                <h4 class="text-lg font-semibold mb-1">
                    📋 Entregas
                </h4>
                <p class="text-sm text-green-100">
                    Ver entregas del aula
                </p>

                <span class="block mt-4 text-sm font-semibold opacity-90 group-hover:opacity-100">
                    Ver →
                </span>
            </a>

            {{-- Alumnos --}}
            <div class="bg-purple-600 text-white p-6 rounded-xl shadow">
                <h4 class="text-lg font-semibold mb-1">
                    👨‍🎓 Alumnos
                </h4>
                <p class="text-sm text-purple-100">
                    Total registrados
                </p>

                <p class="text-3xl font-bold mt-4">
                    {{ $aula->alumnos->count() }}
                </p>
            </div>

        </div>

        {{-- Lista de alumnos --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="text-2xl font-bold text-gray-800 mb-4">
                Lista de alumnos
            </h4>

            <ul class="divide-y">
                @forelse($aula->alumnos as $alumno)

                    @php
                        $ficha = $alumno->fichaActual;
                    @endphp

                    <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        {{-- Datos del alumno --}}
                        <div>
                            <p class="text-gray-800 font-medium">
                                {{ $alumno->nombre_completo }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Matrícula: {{ $alumno->codigo_matricula }}
                            </p>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex items-center gap-3">

                            {{-- Estado --}}
                            @if(!$ficha)
                                <span class="px-3 py-1 text-xs rounded bg-gray-200 text-gray-700">
                        Sin ficha
                    </span>
                            @elseif($ficha->aceptado)
                                <span class="px-3 py-1 text-xs rounded bg-green-100 text-green-700">
                        Aceptada
                    </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                        Pendiente
                    </span>
                            @endif

                            {{-- Ver ficha --}}
                            @if($ficha)
                                <a href="{{ route('profesor.fichas.show', $ficha) }}"
                                   class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Ver ficha
                                </a>
                            @endif

                            {{-- Aceptar ficha --}}
                            @if($ficha && !$ficha->aceptado)
                                <form method="POST"
                                      action="{{ route('profesor.fichas.aceptar', $ficha) }}"
                                      onsubmit="return confirm('¿Aceptar la ficha de registro de este alumno?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                        Aceptar
                                    </button>
                                </form>
                            @endif

                        </div>
                    </li>

                @empty
                    <li class="py-4 text-center text-gray-500">
                        No hay alumnos registrados en esta aula.
                    </li>
                @endforelse
            </ul>

        </div>

    </div>

</x-app-layout>

