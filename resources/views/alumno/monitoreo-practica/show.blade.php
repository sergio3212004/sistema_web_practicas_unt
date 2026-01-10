@php
    use Illuminate\Support\Facades\Storage;
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-clipboard-document-check', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Monitoreo de Prácticas
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Semana {{ $monitoreoPractica->semana->numero }} {{ $monitoreoPractica->semana->nombre ? '- ' . $monitoreoPractica->semana->nombre : '' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('alumno.monitoreos-practicas.download-pdf', $monitoreoPractica) }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                    @svg('heroicon-o-arrow-down-tray', 'w-5 h-5 mr-2')
                    Descargar PDF
                </a>
                <a href="{{ route('alumno.monitoreos-practicas.index', $monitoreoPractica->semana) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Contenedor principal -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-200">

                <!-- Encabezado oficial -->
                <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-8 py-8">
                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-xl">
                                @svg('heroicon-o-academic-cap', 'w-12 h-12 text-blue-800')
                            </div>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-2">
                            FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS
                        </h1>
                        <h2 class="text-xl font-semibold text-blue-100 mb-2">
                            PROGRAMA DE INFORMÁTICA
                        </h2>
                        <h3 class="text-lg font-medium text-blue-200 mb-1">
                            MONITOREO DE PRÁCTICAS PRE PROFESIONALES
                        </h3>
                        <div class="inline-block bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-bold text-sm mt-3 shadow-lg">
                            FORMATO 03: MONITOREO DE PRÁCTICAS
                        </div>
                    </div>
                </div>

                <div class="p-8">

                    <!-- Sección 1: DEL ESTUDIANTE -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-user', 'w-5 h-5 mr-2')
                                DEL ESTUDIANTE
                            </h3>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Apellidos y Nombres
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900 font-medium">
                                        {{ $monitoreoPractica->alumno->user->nombre }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nro. Matrícula
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->codigo_matricula }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Celular
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->user->telefono ?? 'No registrado' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: DE LA EMPRESA -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-building-office', 'w-5 h-5 mr-2')
                                DE LA EMPRESA DONDE REALIZA LA PRÁCTICA
                            </h3>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Razón Social
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->fichaRegistro->razon_social }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Área o unidad donde se realizará la práctica
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->fichaRegistro->area_practicas }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: DEL JEFE DIRECTO -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-user-circle', 'w-5 h-5 mr-2')
                                DEL JEFE DIRECTO DEL PRACTICANTE
                            </h3>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->fichaRegistro->nombre_jefe_directo }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Cargo
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->fichaRegistro->cargo ?? 'No especificado' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Celular
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->fichaRegistro->telefono_jefe_directo }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->fichaRegistro->correo_jefe_directo }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: DEL PROFESOR SUPERVISOR -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-academic-cap', 'w-5 h-5 mr-2')
                                DEL PROFESOR SUPERVISOR
                            </h3>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->aula->profesor->user->nombre ?? 'No asignado' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo
                                    </label>
                                    <div class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-white text-gray-900">
                                        {{ $monitoreoPractica->alumno->aula->profesor->user->email ?? 'No asignado' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 5: TABLA DE ACTIVIDADES -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2')
                                ACTIVIDADES DE LA SEMANA {{ $monitoreoPractica->semana->numero }}
                            </h3>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border-2 border-blue-200 rounded-lg overflow-hidden">
                                    <thead class="bg-blue-800">
                                    <tr>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-16">
                                            Nro
                                        </th>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-32">
                                            Fecha
                                        </th>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Actividad
                                        </th>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-32">
                                            Nivel de Avance
                                        </th>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-64">
                                            Observaciones
                                        </th>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-40">
                                            Firma Practicante
                                        </th>
                                        <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-40">
                                            Firma Profesor
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-blue-200">
                                    @foreach($monitoreoPractica->monitoreosPracticasActividades as $index => $actividad)
                                        <tr class="hover:bg-blue-50 transition-colors">
                                            <td class="border-2 border-blue-200 px-4 py-4 text-center text-sm font-bold text-gray-900">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="border-2 border-blue-200 px-4 py-4 text-center text-sm text-gray-700">
                                                {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
                                            </td>
                                            <td class="border-2 border-blue-200 px-4 py-4 text-sm text-gray-700">
                                                {{ $actividad->cronogramaActividad->actividad }}
                                            </td>
                                            <td class="border-2 border-blue-200 px-4 py-4 text-center">
                                                @if($actividad->al_dia)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                        @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                                        Al día
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                        @svg('heroicon-o-x-circle', 'w-4 h-4 mr-1')
                                                        Atrasado
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border-2 border-blue-200 px-4 py-4 text-sm text-gray-700">
                                                {{ $actividad->observacion ?? 'Sin observaciones' }}
                                            </td>
                                            <td class="border-2 border-blue-200 px-4 py-4 text-center">
                                                @if($actividad->firma_practicante)
                                                    <img src="{{ Storage::url($actividad->firma_practicante) }}"
                                                         alt="Firma Practicante"
                                                         class="max-w-full h-16 mx-auto border border-gray-300 rounded">
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Sin firma</span>
                                                @endif
                                            </td>
                                            <td class="border-2 border-blue-200 px-4 py-4 text-center">
                                                @if($actividad->firma_supervisor)
                                                    <img src="{{ Storage::url($actividad->firma_supervisor) }}"
                                                         alt="Firma Supervisor"
                                                         class="max-w-full h-16 mx-auto border border-gray-300 rounded">
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Pendiente</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
