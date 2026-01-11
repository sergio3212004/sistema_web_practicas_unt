<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('profesor.formato-doce.list', $aula->id) }}"
                       class="text-blue-700 hover:text-blue-900 transition duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-blue-900">Nuevo Formato de Monitoreo F12</h1>
                        <p class="text-gray-600 mt-1">{{ $aula->curso->nombre ?? 'Sin Curso' }} - Ciclo {{ $aula->ciclo ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Aula -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-900 rounded-lg shadow-sm p-6 mb-6 text-white">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-blue-100 text-sm">Semestre</p>
                        <p class="font-semibold text-lg">{{ $aula->semestre->nombre ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Ciclo</p>
                        <p class="font-semibold text-lg">{{ $aula->ciclo ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Aula</p>
                        <p class="font-semibold text-lg">{{ $aula->numero ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Total Alumnos</p>
                        <p class="font-semibold text-lg">{{ $aula->alumnos->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('profesor.formato-doce.store', $aula->id) }}" method="POST" id="formatoDoceForm">
                @csrf

                <!-- Información General del Formato -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Información General
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha de Monitoreo
                            </label>
                            <input type="date"
                                   value="{{ date('Y-m-d') }}"
                                   readonly
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-medium">
                        </div>

                        <div>
                            <label for="nivel" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nivel de la Práctica Pre Profesional <span class="text-red-500">*</span>
                            </label>
                            <select name="nivel" id="nivel" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccione un nivel</option>
                                <option value="inicial">Inicial</option>
                                <option value="intermedio">Intermedio</option>
                                <option value="avanzado">Avanzado</option>
                            </select>
                            @error('nivel')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            Registro de Estudiantes
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Complete la información de cada estudiante para el monitoreo</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-8">N°</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Apellidos y Nombres</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Sede de Práctica</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Responsable</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Contacto</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nivel de Avance</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Observaciones</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="alumnosTableBody">
                            @foreach($aula->alumnos as $index => $alumno)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <div class="font-medium">{{ $alumno->nombre_completo }}</div>
                                        <div class="text-xs text-gray-500">{{ $alumno->codigo_matricula }}</div>
                                        <input type="hidden" name="alumnos[{{ $index }}][alumno_id]" value="{{ $alumno->id }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text"
                                               name="alumnos[{{ $index }}][sede_practica]"
                                               required
                                               placeholder="Ingrese sede de práctica"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text"
                                               name="alumnos[{{ $index }}][responsable]"
                                               required
                                               placeholder="Nombre del responsable"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text"
                                               name="alumnos[{{ $index }}][contacto_responsable]"
                                               required
                                               placeholder="Correo/Teléfono"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio"
                                                       name="alumnos[{{ $index }}][al_dia]"
                                                       value="1"
                                                       required
                                                       class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                                                <span class="ml-2 text-sm text-gray-700">Al día</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio"
                                                       name="alumnos[{{ $index }}][al_dia]"
                                                       value="0"
                                                       class="form-radio h-4 w-4 text-red-600 focus:ring-red-500">
                                                <span class="ml-2 text-sm text-gray-700">Atrasado</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <textarea name="alumnos[{{ $index }}][observaciones]"
                                                  rows="2"
                                                  placeholder="Observaciones opcionales"
                                                  class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Firma Digital -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Firma del Docente Responsable del Monitoreo <span class="text-red-500">*</span>
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                                <canvas id="signaturePad"
                                        class="w-full h-48 bg-white rounded border border-gray-300 cursor-crosshair"
                                        style="touch-action: none;"></canvas>
                                <input type="hidden" name="firma_coordinador" id="firmaCoordinadorInput" required>
                            </div>
                            <div class="mt-3 flex gap-3">
                                <button type="button"
                                        id="clearSignature"
                                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Limpiar Firma
                                </button>
                            </div>
                            @error('firma_coordinador')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                            <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Instrucciones
                            </h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Dibuje su firma en el recuadro usando el mouse o pantalla táctil
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Use el botón "Limpiar Firma" si desea volver a firmar
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    La firma es obligatoria para guardar el formato
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Asegúrese de completar todos los campos requeridos antes de enviar
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('profesor.formato-doce.list', $aula->id) }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition duration-200 text-center">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-8 py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar Formato de Monitoreo
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configurar Signature Pad
                const canvas = document.getElementById('signaturePad');
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)',
                    penColor: 'rgb(0, 0, 0)'
                });

                // Ajustar el tamaño del canvas
                function resizeCanvas() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                    signaturePad.clear();
                }

                window.addEventListener("resize", resizeCanvas);
                resizeCanvas();

                // Botón limpiar firma
                document.getElementById('clearSignature').addEventListener('click', function() {
                    signaturePad.clear();
                    document.getElementById('firmaCoordinadorInput').value = '';
                });

                // Guardar firma al enviar formulario
                document.getElementById('formatoDoceForm').addEventListener('submit', function(e) {
                    if (signaturePad.isEmpty()) {
                        e.preventDefault();
                        alert('Por favor, firme el documento antes de enviarlo.');
                        return false;
                    }

                    // Convertir la firma a base64 y guardarla en el input hidden
                    const dataURL = signaturePad.toDataURL();
                    document.getElementById('firmaCoordinadorInput').value = dataURL;
                });
            });
        </script>
    @endpush
</x-app-layout>
