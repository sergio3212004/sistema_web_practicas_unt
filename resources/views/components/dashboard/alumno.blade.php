@props(['alumno'])

@if($alumno->aula)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <!-- Card del Aula -->
        <a href="{{ route('alumno.aula.index', $alumno->aula) }}"
           class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">

            <!-- Encabezado con gradiente -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 px-6 py-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-5 rounded-full -ml-12 -mb-12"></div>

                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-indigo-200 text-xs font-medium uppercase tracking-wider mb-1">Mi Aula</p>
                        <h5 class="text-2xl font-bold text-white">
                            Aula {{ $alumno->aula->numero }}
                        </h5>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 group-hover:bg-opacity-30 transition-all">
                        @svg('heroicon-o-academic-cap', 'w-7 h-7 text-white')
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="px-6 py-5 space-y-4">
                <!-- Semestre -->
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                        @svg('heroicon-o-calendar', 'w-5 h-5 text-indigo-600')
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Semestre</p>
                        <p class="text-sm font-semibold text-gray-900 mt-0.5">
                            {{ $alumno->aula->semestre->nombre ?? '—' }}
                        </p>
                    </div>
                </div>

                <!-- Docente -->
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        @svg('heroicon-o-user', 'w-5 h-5 text-purple-600')
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Docente</p>
                        <p class="text-sm font-semibold text-gray-900 mt-0.5">
                            {{ $alumno->aula->profesor->user->nombre ?? '—' }}
                        </p>
                    </div>
                </div>

                <!-- Footer con badge y acción -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-xs font-semibold text-emerald-800">Activa</span>
                    </span>

                    <span class="text-indigo-600 text-sm font-medium group-hover:text-indigo-800 flex items-center">
                        Ver entregas
                        @svg('heroicon-o-arrow-right', 'w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform')
                    </span>
                </div>
            </div>
        </a>

        <!-- Card de Estadísticas de Entregas -->
        <div class="bg-gradient-to-br from-slate-50 to-indigo-50 rounded-2xl shadow-sm p-6 border border-slate-200">
            <div class="flex items-center justify-between mb-5">
                <h6 class="text-sm font-semibold text-gray-900">Mis Entregas</h6>
                @svg('heroicon-o-document-text', 'w-5 h-5 text-indigo-600')
            </div>

            @php
                // Obtener entregas del alumno
                $entregas = $alumno->entregas;
                $totalEntregas = $entregas->count();

                // Calcular estadísticas
                $entregasPendientes = $entregas->where('estado', 'pendiente')->count();
                $entregasEntregadas = $entregas->where('estado', 'entregado')->count();
                $entregasRevisadas = $entregas->where('estado', 'observado')->count();
                $entregasCalificadas = $entregas->filter(function($e) { return !is_null($e->nota); })->count();

                // Calcular progreso (entregas completadas vs total)
                $progreso = $totalEntregas > 0 ? round((($entregasEntregadas + $entregasRevisadas) / $totalEntregas) * 100) : 0;

                // Promedio de notas
                $notasValidas = $entregas->filter(function($e) { return !is_null($e->nota); });
                $promedioNotas = $notasValidas->count() > 0 ? round($notasValidas->avg('nota'), 1) : null;
            @endphp

            <div class="space-y-4">
                <!-- Entregas Pendientes -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                        <span class="text-sm text-gray-600">Pendientes</span>
                    </div>
                    <span class="text-lg font-bold text-amber-600">{{ $entregasPendientes }}</span>
                </div>

                <!-- Entregas Entregadas -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                        <span class="text-sm text-gray-600">Entregadas</span>
                    </div>
                    <span class="text-lg font-bold text-blue-600">{{ $entregasEntregadas }}</span>
                </div>

                <!-- Entregas Revisadas -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                        <span class="text-sm text-gray-600">Revisadas</span>
                    </div>
                    <span class="text-lg font-bold text-emerald-600">{{ $entregasRevisadas }}</span>
                </div>

                <!-- Promedio de Notas -->
                @if($promedioNotas !== null)
                    <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                        <div class="flex items-center space-x-2">
                            @svg('heroicon-o-star', 'w-4 h-4 text-yellow-500')
                            <span class="text-sm text-gray-600">Promedio</span>
                        </div>
                        <span class="text-lg font-bold text-indigo-600">{{ $promedioNotas }}</span>
                    </div>
                @endif
            </div>

            <!-- Barra de Progreso -->
            <div class="mt-5 pt-5 border-t border-slate-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-600">Progreso general</span>
                    <span class="text-xs font-bold text-indigo-600">{{ $progreso }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full transition-all duration-500"
                         style="width: {{ $progreso }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    {{ $entregasEntregadas + $entregasRevisadas }} de {{ $totalEntregas }} entregas completadas
                </p>
            </div>
        </div>

    </div>
@else
    <!-- Estado sin aula asignada -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-2xl mb-4">
                    @svg('heroicon-o-academic-cap', 'w-8 h-8 text-indigo-600')
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Sin aula asignada
                </h3>
                <p class="text-gray-600 text-sm max-w-md mx-auto">
                    Actualmente no cuentas con un aula asignada. Pronto serás notificado cuando se te asigne a un grupo.
                </p>
            </div>

            <div class="px-6 py-6 bg-gray-50 border-t border-gray-200">
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            @svg('heroicon-o-information-circle', 'w-5 h-5 text-indigo-600')
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">¿Qué hacer mientras tanto?</p>
                            <p class="text-xs text-gray-600 mt-1">
                                Puedes explorar las prácticas disponibles y preparar tu ficha de registro.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            @svg('heroicon-o-clock', 'w-5 h-5 text-amber-600')
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Tiempo estimado</p>
                            <p class="text-xs text-gray-600 mt-1">
                                La asignación de aulas se realiza al inicio de cada semestre académico.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="#" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-xl transition-colors">
                        Contactar con coordinación
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
