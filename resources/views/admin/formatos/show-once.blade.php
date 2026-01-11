<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.formatos.index') }}"
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium mb-4 transition-colors">
                @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2')
                Volver al listado
            </a>

            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Formato 11 - Conformidad de PPP</h1>
                    <p class="text-gray-600 mt-2">Aula {{ $formatoOnce->aula->numero }} - {{ $formatoOnce->aula->semestre->nombre ?? 'Sin semestre' }}</p>
                    <p class="text-sm text-gray-500 mt-1">Creado: {{ $formatoOnce->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.formatos.once.pdf', $formatoOnce->id) }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                        @svg('heroicon-o-arrow-down-tray', 'w-5 h-5 mr-2')
                        Descargar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Información del coordinador -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                @svg('heroicon-o-user-circle', 'w-6 h-6 mr-2 text-blue-600')
                Información del Coordinador
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Nombre del Coordinador</p>
                    <p class="text-lg text-gray-900">
                        {{ $formatoOnce->aula->profesor->nombres ?? '' }}
                        {{ $formatoOnce->aula->profesor->apellido_paterno ?? '' }}
                        {{ $formatoOnce->aula->profesor->apellido_materno ?? '' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Fecha</p>
                    <p class="text-lg text-gray-900">{{ $formatoOnce->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            @if($formatoOnce->firma_coordinador)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-600 mb-3">Firma del Coordinador</p>
                    <div class="inline-block border-2 border-gray-300 rounded-lg p-4 bg-gray-50">
                        <img src="{{ asset('storage/' . $formatoOnce->firma_coordinador) }}"
                             alt="Firma del Coordinador"
                             class="max-w-xs h-auto">
                    </div>
                </div>
            @endif
        </div>

        <!-- Tabla de alumnos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    @svg('heroicon-o-academic-cap', 'w-6 h-6 mr-2 text-blue-600')
                    Alumnos Registrados ({{ $formatoOnce->formatoOnceAlumnos->count() }})
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alumno</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sede de Prácticas</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ciclo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Competencias</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Capacidades</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actividades</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Producto</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Conformidad</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Comentarios</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($formatoOnce->formatoOnceAlumnos as $index => $registro)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $registro->alumno->nombre_completo }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $registro->alumno->codigo_matricula }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                {{ $registro->sede_practicas ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $registro->ciclo_nivel ?? '-' }}
                                    </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <div class="max-w-xs">
                                    {{ $registro->competencias ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <div class="max-w-xs">
                                    {{ $registro->capacidades ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <div class="max-w-xs">
                                    {{ $registro->actividades ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <div class="max-w-xs">
                                    {{ $registro->producto ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @if($registro->conformidad)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                            SÍ
                                        </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            @svg('heroicon-o-x-circle', 'w-4 h-4 mr-1')
                                            NO
                                        </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <div class="max-w-xs">
                                    {{ $registro->comentarios ?? '-' }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Alumnos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-4">
                        @svg('heroicon-o-users', 'w-8 h-8 text-blue-600')
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-600">Total Alumnos</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $formatoOnce->formatoOnceAlumnos->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Conformes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-full p-4">
                        @svg('heroicon-o-check-circle', 'w-8 h-8 text-green-600')
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-600">Conformes</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">
                            {{ $formatoOnce->formatoOnceAlumnos->where('conformidad', true)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- No Conformes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-full p-4">
                        @svg('heroicon-o-x-circle', 'w-8 h-8 text-red-600')
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-600">No Conformes</p>
                        <p class="text-3xl font-bold text-red-600 mt-1">
                            {{ $formatoOnce->formatoOnceAlumnos->where('conformidad', false)->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
