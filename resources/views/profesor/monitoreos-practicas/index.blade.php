<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Monitoreo de Prácticas Pre-Profesionales
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $alumno->user->nombre }} - {{ $alumno->codigo_matricula }}
                </p>
            </div>
            <a href="{{ route('profesor.aulas.show', $aula) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2')
                Volver al Aula
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Verificar si el alumno tiene ficha de registro -->
            @if(!$alumno->fichaRegistro)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @svg('heroicon-o-exclamation-triangle', 'w-5 h-5 text-yellow-400')
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-medium">Atención:</span> El alumno aún no ha completado su ficha de registro de prácticas.
                                No es posible visualizar el monitoreo hasta que lo haga.
                            </p>
                        </div>
                    </div>
                </div>
            @else

                <!-- Información del Estudiante y Empresa -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Datos del Practicante -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                @svg('heroicon-o-user-circle', 'w-8 h-8 text-blue-700')
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Practicante</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Nombre:</span>
                                <p class="text-gray-600">{{ $alumno->user->nombre }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Código:</span>
                                <p class="text-gray-600">{{ $alumno->codigo_matricula }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Email:</span>
                                <p class="text-gray-600">{{ $alumno->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Datos de la Empresa -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                @svg('heroicon-o-building-office', 'w-8 h-8 text-green-700')
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Empresa</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Razón Social:</span>
                                <p class="text-gray-600">{{ $alumno->fichaRegistro->razon_social }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">RUC:</span>
                                <p class="text-gray-600">{{ $alumno->fichaRegistro->ruc }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Área:</span>
                                <p class="text-gray-600">{{ $alumno->fichaRegistro->area_practicas }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Periodo de Prácticas -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                                @svg('heroicon-o-calendar-days', 'w-8 h-8 text-purple-700')
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Periodo</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Inicio:</span>
                                <p class="text-gray-600">{{ $alumno->fichaRegistro->fecha_inicio->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Término:</span>
                                <p class="text-gray-600">{{ $alumno->fichaRegistro->fecha_termino->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Duración:</span>
                                <p class="text-gray-600">
                                    {{ $alumno->fichaRegistro->fecha_inicio->diffInDays($alumno->fichaRegistro->fecha_termino) }} días
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de Progreso -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-sm border border-blue-200 p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Progreso del Monitoreo</h3>
                            <p class="text-sm text-gray-600">
                                Seguimiento semanal de las actividades del cronograma
                            </p>
                        </div>
                        <div class="text-center">
                            @php
                                $totalSemanas = $semanas->count();
                                $semanasConMonitoreo = $semanas->filter(function($semana) {
                                    return $semana->monitoreosPracticas->isNotEmpty();
                                })->count();
                                $porcentaje = $totalSemanas > 0 ? round(($semanasConMonitoreo / $totalSemanas) * 100) : 0;
                            @endphp
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white shadow-md border-4 border-blue-500">
                                <span class="text-3xl font-bold text-blue-700">{{ $porcentaje }}%</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ $semanasConMonitoreo }} de {{ $totalSemanas }} semanas
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Timeline de Semanas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Monitoreo por Semanas
                        </h3>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-gray-600">Registrado</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                <span class="text-gray-600">Pendiente</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($semanas as $semana)
                            @php
                                $monitoreo = $semana->monitoreosPracticas->first();
                                $tieneMonitoreo = $monitoreo !== null;
                            @endphp

                            <div class="relative pl-8 pb-8 border-l-2 {{ $tieneMonitoreo ? 'border-green-500' : 'border-gray-300' }} last:border-l-0 last:pb-0">
                                <!-- Indicador de estado -->
                                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full {{ $tieneMonitoreo ? 'bg-green-500' : 'bg-yellow-500' }} border-4 border-white shadow"></div>

                                <!-- Contenido de la semana -->
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-5 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    Semana {{ $semana->numero }}
                                                    @if($semana->nombre)
                                                        - {{ $semana->nombre }}
                                                    @endif
                                                </h4>
                                                @if($tieneMonitoreo)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                                        Registrado
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        @svg('heroicon-o-clock', 'w-4 h-4 mr-1')
                                                        Pendiente
                                                    </span>
                                                @endif
                                            </div>

                                            @if($tieneMonitoreo)
                                                @php
                                                    $totalActividades = $monitoreo->monitoreosPracticasActividades->count();
                                                    $actividadesAlDia = $monitoreo->monitoreosPracticasActividades->where('al_dia', true)->count();
                                                @endphp
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                        <p class="text-xs font-medium text-gray-600 mb-1">Actividades Monitoreadas</p>
                                                        <p class="text-2xl font-bold text-blue-700">{{ $totalActividades }}</p>
                                                    </div>
                                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                        <p class="text-xs font-medium text-gray-600 mb-1">Al Día</p>
                                                        <p class="text-2xl font-bold text-green-700">{{ $actividadesAlDia }}</p>
                                                    </div>
                                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                        <p class="text-xs font-medium text-gray-600 mb-1">Con Retraso</p>
                                                        <p class="text-2xl font-bold text-red-700">{{ $totalActividades - $actividadesAlDia }}</p>
                                                    </div>
                                                </div>

                                                <!-- Lista de actividades monitoreadas -->
                                                @if($monitoreo->monitoreosPracticasActividades->isNotEmpty())
                                                    <div class="mt-4 space-y-2">
                                                        <p class="text-sm font-medium text-gray-700">Actividades del Cronograma:</p>
                                                        @foreach($monitoreo->monitoreosPracticasActividades as $actividadMonitoreada)
                                                            <div class="flex items-center justify-between bg-white p-3 rounded border border-gray-200">
                                                                <div class="flex items-center gap-2">
                                                                    @if($actividadMonitoreada->al_dia)
                                                                        @svg('heroicon-o-check-circle', 'w-5 h-5 text-green-600')
                                                                    @else
                                                                        @svg('heroicon-o-x-circle', 'w-5 h-5 text-red-600')
                                                                    @endif
                                                                    <span class="text-sm text-gray-700">
                                                                        {{ $actividadMonitoreada->cronogramaActividad->actividad ?? 'Actividad no especificada' }}
                                                                    </span>
                                                                </div>
                                                                <span class="text-xs px-2 py-1 rounded {{ $actividadMonitoreada->al_dia ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                    {{ $actividadMonitoreada->al_dia ? 'Al día' : 'Con retraso' }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @else
                                                <p class="text-sm text-gray-600 mt-2">
                                                    El alumno aún no ha registrado el monitoreo para esta semana.
                                                </p>
                                            @endif
                                        </div>

                                        @if($tieneMonitoreo)
                                            <div class="flex gap-2">
                                                <a href="{{ route('profesor.monitoreos-practicas.show', $monitoreo) }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                    @svg('heroicon-o-eye', 'w-4 h-4 mr-2')
                                                    Ver Detalle
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                @svg('heroicon-o-calendar-days', 'w-16 h-16 mx-auto text-gray-400 mb-4')
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay semanas registradas</h3>
                                <p class="text-gray-600">El aula no tiene semanas configuradas para el monitoreo</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            @endif {{-- fin de if fichaRegistro --}}

        </div>
    </div>
</x-app-layout>
