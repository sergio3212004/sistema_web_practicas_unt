<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profesor.formato-doce.list', $formato->aula->id) }}"
                           class="text-blue-700 hover:text-blue-900 transition duration-150">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-blue-900">Formato de Monitoreo F12</h1>
                            <p class="text-gray-600 mt-1">{{ $formato->aula->curso->nombre ?? 'Sin Curso' }} - Ciclo {{ $formato->aula->ciclo ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('profesor.formato-doce.pdf', $formato->id) }}"
                           target="_blank"
                           class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Descargar PDF
                        </a>
                        <form action="{{ route('profesor.formato-doce.destroy', $formato->id) }}"
                              method="POST"
                              onsubmit="return confirm('¿Está seguro de eliminar este formato? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información General -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-900 rounded-lg shadow-sm p-6 mb-6 text-white">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Información del Monitoreo
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-blue-100 text-sm">Fecha de Monitoreo</p>
                        <p class="font-semibold text-lg">{{ $formato->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Semestre</p>
                        <p class="font-semibold text-lg">{{ $formato->aula->semestre->nombre ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Ciclo</p>
                        <p class="font-semibold text-lg">{{ $formato->aula->ciclo ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Aula</p>
                        <p class="font-semibold text-lg">{{ $formato->aula->numero ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Nivel de Práctica</p>
                        <p class="font-semibold text-lg uppercase">{{ $formato->nivel }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Total Estudiantes</p>
                        <p class="font-semibold text-lg">{{ $formato->formatosDoceAlumnos->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de Estudiantes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200 bg-blue-50">
                    <h2 class="text-xl font-bold text-blue-900 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Registro de Estudiantes Monitoreados
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">N°</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Apellidos y Nombres</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Sede de Práctica</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Responsable</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Contacto</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Nivel de Avance</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Observaciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($formato->formatosDoceAlumnos as $index => $registro)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="font-medium">{{ $registro->alumno->nombre_completo }}</div>
                                    <div class="text-xs text-gray-500">{{ $registro->alumno->codigo_matricula }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registro->sede_practica }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registro->responsable }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registro->contacto_responsable }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($registro->al_dia)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Al día
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Atrasado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $registro->observaciones ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Firma -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Firma del Docente Responsable del Monitoreo
                </h2>
                <div class="border-2 border-gray-300 rounded-lg p-4 bg-gray-50 inline-block">
                    @if($formato->firma_coordinador)
                        <img src="{{ asset('storage/' . $formato->firma_coordinador) }}"
                             alt="Firma del coordinador"
                             class="max-w-xs h-32 object-contain">
                    @else
                        <p class="text-gray-500 italic">Sin firma</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
