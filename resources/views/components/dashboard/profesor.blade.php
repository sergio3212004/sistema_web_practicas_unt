@props(['profesor', 'aulas', 'semestreActivo', 'totalEntregas', 'actividadesActivas'])

<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">
                Bienvenido, {{ $profesor->user->nombre }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Panel de control del docente - Gestiona tus aulas y supervisa el progreso de tus estudiantes
            </p>
        </div>
        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-blue-100 px-4 py-2 rounded-xl">
                <p class="text-xs text-blue-600 font-medium">Código Docente</p>
                <p class="text-sm font-bold text-blue-900">{{ $profesor->codigo_profesor }}</p>
            </div>
        </div>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto space-y-6">
    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total de Aulas -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    @svg('heroicon-o-academic-cap', 'w-8 h-8')
                </div>
                <span class="text-3xl font-bold">{{ $aulas->count() }}</span>
            </div>
            <h3 class="text-sm font-medium opacity-90">Aulas Asignadas</h3>
            <p class="text-xs opacity-75 mt-1">Grupos bajo tu supervisión</p>
        </div>

        <!-- Total de Alumnos -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    @svg('heroicon-o-users', 'w-8 h-8')
                </div>
                <span class="text-3xl font-bold">{{ $aulas->sum(fn($aula) => $aula->alumnos->count()) }}</span>
            </div>
            <h3 class="text-sm font-medium opacity-90">Total de Alumnos</h3>
            <p class="text-xs opacity-75 mt-1">Estudiantes en tus aulas</p>
        </div>

        <!-- Actividades Activas -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    @svg('heroicon-o-clipboard-document-check', 'w-8 h-8')
                </div>
                <span class="text-3xl font-bold">{{ $actividadesActivas }}</span>
            </div>
            <h3 class="text-sm font-medium opacity-90">Actividades Activas</h3>
            <p class="text-xs opacity-75 mt-1">En período de entrega</p>
        </div>

        <!-- Semestre Activo -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    @svg('heroicon-o-calendar', 'w-8 h-8')
                </div>
                <span class="text-xl font-bold truncate">{{ $semestreActivo->nombre }}</span>
            </div>
            <h3 class="text-sm font-medium opacity-90">Semestre Activo</h3>
            <p class="text-xs opacity-75 mt-1">Periodo académico actual</p>
        </div>
    </div>

    <!-- Sección de Aulas -->
    @if($aulas->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Mis Aulas</h3>
                    <p class="text-sm text-gray-600 mt-1">Gestiona tus grupos de estudiantes</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($aulas as $aula)
                    <a href="{{ route('profesor.aulas.show', $aula) }}"
                       class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">

                        <!-- Encabezado con gradiente -->
                        <div class="bg-gradient-to-br from-blue-800 to-blue-900 px-6 py-6 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-16 -mt-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-5 rounded-full -ml-12 -mb-12"></div>

                            <div class="relative flex items-center justify-between">
                                <div>
                                    <p class="text-blue-200 text-xs font-medium uppercase tracking-wider mb-1">Aula</p>
                                    <h5 class="text-2xl font-bold text-white">
                                        Aula {{ $aula->numero }}
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
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                    @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-600')
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Semestre</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                        {{ $aula->semestre->nombre ?? '—' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Total de Alumnos -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                    @svg('heroicon-o-users', 'w-5 h-5 text-purple-600')
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Alumnos</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                        {{ $aula->alumnos->count() }} estudiantes
                                    </p>
                                </div>
                            </div>

                            <!-- Semanas y Actividades -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                    @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 text-green-600')
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Contenido</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                        {{ $aula->semanas->count() }} semanas, {{ $aula->actividades->count() }} actividades
                                    </p>
                                </div>
                            </div>

                            <!-- Entregas -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                                    @svg('heroicon-o-document-text', 'w-5 h-5 text-orange-600')
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Entregas</p>
                                    @php
                                        $totalEntregasAula = $aula->actividades->sum(fn($actividad) => $actividad->entregas->count());
                                    @endphp
                                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                        {{ $totalEntregasAula }} trabajos enviados
                                    </p>
                                </div>
                            </div>

                            <!-- Footer con badge y acción -->
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-50 border border-green-200">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    <span class="text-xs font-semibold text-green-800">Activa</span>
                                </span>

                                <span class="text-blue-600 text-sm font-medium group-hover:text-blue-800 flex items-center">
                                    Ver detalles
                                    @svg('heroicon-o-arrow-right', 'w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform')
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <!-- Estado sin aulas asignadas -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-2xl mb-6">
                        @svg('heroicon-o-academic-cap', 'w-10 h-10 text-blue-600')
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        Sin aulas asignadas
                    </h3>
                    <p class="text-gray-600 text-base max-w-md mx-auto">
                        Actualmente no tienes aulas asignadas. El administrador te asignará grupos próximamente.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
