<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Monitoreo de Prácticas Pre-Profesionales
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Semana {{ $semana->numero }}{{ $semana->nombre ? ' - ' . $semana->nombre : '' }}
                </p>
            </div>
            <a href="{{ route('alumno.aula.index', $semana->aula) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2')
                Volver al Aula
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Información del Alumno -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                        @svg('heroicon-o-user-circle', 'w-8 h-8 text-blue-700')
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Mis Datos</h3>
                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                            <p><span class="font-medium">Nombre:</span> {{ auth()->user()->alumno->nombreCompleto }}</p>
                            <p><span class="font-medium">Código:</span> {{ auth()->user()->alumno->codigo_matricula }}</p>
                            @if(auth()->user()->alumno->fichaRegistro)
                                <p><span class="font-medium">Empresa:</span> {{ auth()->user()->alumno->fichaRegistro->razon_social }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado del Monitoreo -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">
                            Monitoreo - Semana {{ $semana->numero }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $semana->nombre ?? 'Sin nombre' }}
                        </p>
                    </div>

                    @if($monitoreo)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                            Registrado
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            @svg('heroicon-o-exclamation-triangle', 'w-4 h-4 mr-1')
                            Pendiente
                        </span>
                    @endif
                </div>

                <div class="mt-6">
                    @if($monitoreo)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mb-4">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">Fecha de registro:</span>
                                {{ $monitoreo->created_at->format('d/m/Y H:i') }}
                            </p>
                            @if($monitoreo->observaciones)
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium">Observaciones:</span>
                                    {{ $monitoreo->observaciones }}
                                </p>
                            @endif
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('alumno.monitoreos-practicas.show', $monitoreo) }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                                @svg('heroicon-o-eye', 'w-4 h-4 mr-2')
                                Ver Detalles
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                                @svg('heroicon-o-document-text', 'w-8 h-8 text-yellow-600')
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No has registrado tu monitoreo</h3>
                            <p class="text-gray-600 max-w-md mx-auto mb-6">
                                Completa el formulario de monitoreo para esta semana y envíalo a tu profesor para su revisión.
                            </p>
                            <a href="{{ route('alumno.monitoreos-practicas.create', ['semana_id' => $semana->id]) }}"
                               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                @svg('heroicon-o-plus-circle', 'w-5 h-5 mr-2')
                                Registrar Monitoreo
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
