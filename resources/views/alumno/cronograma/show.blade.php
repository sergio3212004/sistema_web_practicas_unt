<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Encabezado con estado -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">PLAN DE PRÁCTICAS PRE-PROFESIONALES</h1>
                        <p class="text-sm mt-1">FORMATO 02: PLAN DE PRÁCTICAS</p>
                    </div>
                    <div class="text-right">
                        @if($cronograma->estaFirmadoCompleto())
                            <span class="inline-block px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                            ✓ Completado
                        </span>
                        @else
                            <span class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-full text-sm font-semibold">
                            ⏳ Firmas Pendientes
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Estado de Firmas -->
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="font-semibold text-gray-800 mb-3">Estado de Firmas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Firma Practicante -->
                        <div class="flex items-center space-x-3">
                            @if($cronograma->firma_practicante_at)
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Practicante</p>
                                    <p class="text-xs text-gray-600">{{ $cronograma->firma_practicante_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600">✗</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Practicante</p>
                                    <p class="text-xs text-gray-500">Pendiente</p>
                                </div>
                            @endif
                        </div>

                        <!-- Firma Jefe -->
                        <div class="flex items-center space-x-3">
                            @if($cronograma->firma_jefe_directo_at)
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Jefe Directo</p>
                                    <p class="text-xs text-gray-600">{{ $cronograma->firma_jefe_directo_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">⏳</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Jefe Directo</p>
                                    <p class="text-xs text-yellow-600">Esperando firma</p>
                                </div>
                            @endif
                        </div>

                        <!-- Firma Profesor -->
                        <div class="flex items-center space-x-3">
                            @if($cronograma->firma_profesor_at)
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Profesor Supervisor</p>
                                    <p class="text-xs text-gray-600">{{ $cronograma->firma_profesor_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">⏳</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Profesor Supervisor</p>
                                    <p class="text-xs text-yellow-600">Esperando firma</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido del cronograma -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
                <!-- 1. ESTUDIANTE -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        1. ESTUDIANTE
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos y Nombre</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->alumno->nombre_completo }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nro. Matrícula</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->alumno->codigo_matricula }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ciclo</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->ciclo }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Año y Semestre</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->semestre->nombre ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2. EMPRESA -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        2. EMPRESA O INSTITUCIÓN
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Razón Social</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->razon_social }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RUC</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->ruc }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->direccion }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 3. CARACTERÍSTICAS -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        3. CARACTERÍSTICAS DE LA PRÁCTICA
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->fecha_inicio->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Término</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->fecha_termino->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Horarios -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Días y Horario</label>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Día</th>
                                    <th class="border border-gray-300 px-4 py-2">Horario</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                @endphp
                                @foreach($cronograma->fichaRegistro->horarios as $horario)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2 font-medium">
                                            {{ $dias[$horario->dia_semana - 1] }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            De {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área de Prácticas</label>
                        <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                            {{ $cronograma->fichaRegistro->area_practicas }}
                        </p>
                    </div>
                </div>

                <!-- 4. ACTIVIDADES PRINCIPALES -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        4. ACTIVIDADES PRINCIPALES A REALIZARSE EN LA PRÁCTICA
                    </h2>

                    @foreach($cronograma->actividades as $index => $actividad)
                        <div class="mb-6 p-4 border border-gray-300 rounded-lg bg-gray-50">
                            <h3 class="font-semibold text-lg text-gray-700 mb-3">Actividad {{ $index + 1 }}</h3>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <p class="px-3 py-2 bg-white border border-gray-200 rounded-md">
                                    {{ $actividad->actividad }}
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 text-sm">
                                    <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 1</th>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 2</th>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 3</th>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 4</th>
                                    </tr>
                                    <tr>
                                        @for($i = 1; $i <= 4; $i++)
                                            @for($j = 1; $j <= 4; $j++)
                                                <th class="border border-gray-300 px-2 py-1 bg-gray-100">S{{ $j }}</th>
                                            @endfor
                                        @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @for($mes = 1; $mes <= 4; $mes++)
                                            @for($semana = 1; $semana <= 4; $semana++)
                                                @php
                                                    $campo = "m{$mes}_s{$semana}";
                                                    $marcado = $actividad->$campo;
                                                @endphp
                                                <td class="border border-gray-300 px-2 py-2 text-center {{ $marcado ? 'bg-green-100' : '' }}">
                                                    @if($marcado)
                                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                                    @else
                                                        <span class="text-gray-300">-</span>
                                                    @endif
                                                </td>
                                            @endfor
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Sección de Firmas -->
                <div class="border-t-2 border-gray-300 pt-6 mt-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Firmas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- VB° Jefe Inmediato -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-400 pt-2">
                                @if($cronograma->firma_jefe_directo_at)
                                    <div class="mb-2">
                                        <svg class="w-12 h-12 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-1">Firmado el:</p>
                                    <p class="text-xs font-medium">{{ $cronograma->firma_jefe_directo_at->format('d/m/Y H:i') }}</p>
                                @else
                                    <p class="text-yellow-600 text-sm font-medium mb-2">Pendiente</p>
                                @endif
                                <p class="font-medium text-sm mt-2">VB° Jefe Inmediato</p>
                                <p class="text-xs text-gray-600">(Firma y Sello)</p>
                            </div>
                        </div>

                        <!-- Firma del Practicante -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-400 pt-2">
                                @if($cronograma->firma_practicante_at)
                                    <div class="mb-2">
                                        <svg class="w-12 h-12 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-1">Firmado el:</p>
                                    <p class="text-xs font-medium">{{ $cronograma->firma_practicante_at->format('d/m/Y H:i') }}</p>
                                @endif
                                <p class="font-medium text-sm mt-2">Firma del Practicante</p>
                            </div>
                        </div>

                        <!-- VB° Profesor Supervisor -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-400 pt-2">
                                @if($cronograma->firma_profesor_at)
                                    <div class="mb-2">
                                        <svg class="w-12 h-12 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-1">Firmado el:</p>
                                    <p class="text-xs font-medium">{{ $cronograma->firma_profesor_at->format('d/m/Y H:i') }}</p>
                                @else
                                    <p class="text-yellow-600 text-sm font-medium mb-2">Pendiente</p>
                                @endif
                                <p class="font-medium text-sm mt-2">VB° Profesor Supervisor</p>
                                <p class="text-xs text-gray-600">(Firma)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('alumno.ficha.index') }}"
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Volver
                    </a>

                    @if($cronograma->estaFirmadoCompleto())
                        <button onclick="window.print()"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Imprimir / Descargar PDF
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
        }
    </style>
</x-app-layout>
