<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-clipboard-document-check', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Nuevo Monitoreo de Prácticas
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Semana {{ $semana->numero }} {{ $semana->nombre ? '- ' . $semana->nombre : '' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('alumno.monitoreos-practicas.index', $semana) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
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

                    <!-- Alerta de errores -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @svg('heroicon-o-exclamation-triangle', 'w-6 h-6 text-red-600')
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-red-800 mb-2">Por favor, corrija los siguientes errores:</h4>
                                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('alumno.monitoreos-practicas.store') }}" method="POST" id="formMonitoreo">
                        @csrf
                        <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                        <input type="hidden" name="semana_id" value="{{ $semana->id }}">
                        <input type="hidden" name="cronograma_id" value="{{ $cronograma->id }}">

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
                                        <input type="text" value="{{ $alumno->user->nombre }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700 font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nro. Matrícula
                                        </label>
                                        <input type="text" value="{{ $alumno->codigo_matricula }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Celular
                                        </label>
                                        <input type="text" value="{{ $alumno->user->telefono ?? 'No registrado' }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Correo
                                        </label>
                                        <input type="text" value="{{ $alumno->user->email }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
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
                                        <input type="text" value="{{ $alumno->fichaRegistro->razon_social }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Área o unidad donde se realizará la práctica
                                        </label>
                                        <input type="text" value="{{ $alumno->fichaRegistro->area_practicas }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
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
                                        <input type="text" value="{{ $alumno->fichaRegistro->nombre_jefe_directo }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Cargo
                                        </label>
                                        <input type="text" value="{{ $alumno->fichaRegistro->cargo ?? 'No especificado' }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Celular
                                        </label>
                                        <input type="text" value="{{ $alumno->fichaRegistro->telefono_jefe_directo }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Correo
                                        </label>
                                        <input type="text" value="{{ $alumno->fichaRegistro->correo_jefe_directo }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
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
                                        <input type="text" value="{{ $alumno->aula->profesor->user->nombre ?? 'No asignado' }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Correo
                                        </label>
                                        <input type="text" value="{{ $alumno->aula->profesor->user->email ?? 'No asignado' }}" readonly
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 5: TABLA DE ACTIVIDADES -->
                        <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2')
                                    ACTIVIDADES DE LA SEMANA {{ $semana->numero }}
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
                                            <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-40">
                                                Fecha
                                            </th>
                                            <th class="border-2 border-blue-200 px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                                Actividad
                                            </th>
                                            <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-40">
                                                Nivel de Avance
                                            </th>
                                            <th class="border-2 border-blue-200 px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-80">
                                                Observaciones
                                            </th>
                                            <th class="border-2 border-blue-200 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-48">
                                                Firma Practicante
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y-2 divide-blue-200">
                                        @foreach($actividadesSemana as $index => $actividad)
                                            <tr class="hover:bg-blue-50 transition-colors">
                                                <td class="border-2 border-blue-200 px-4 py-4 text-center text-sm font-bold text-gray-900">
                                                    {{ $index + 1 }}
                                                </td>
                                                <td class="border-2 border-blue-200 px-4 py-4">
                                                    <input type="date"
                                                           name="actividades[{{ $index }}][fecha]"
                                                           value="{{ old('actividades.' . $index . '.fecha') }}"
                                                           required
                                                           class="w-full px-3 py-2 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                </td>
                                                <td class="border-2 border-blue-200 px-4 py-4 text-sm text-gray-700">
                                                    {{ $actividad->actividad }}
                                                    <input type="hidden" name="actividades[{{ $index }}][cronograma_actividad_id]" value="{{ $actividad->id }}">
                                                </td>
                                                <td class="border-2 border-blue-200 px-4 py-4">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio"
                                                                   name="actividades[{{ $index }}][al_dia]"
                                                                   value="0"
                                                                   class="form-radio h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500"
                                                                   required>
                                                            <span class="ml-2 text-sm font-medium text-gray-700">Atrasado</span>
                                                        </label>
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="radio"
                                                                   name="actividades[{{ $index }}][al_dia]"
                                                                   value="1"
                                                                   class="form-radio h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500"
                                                                   required>
                                                            <span class="ml-2 text-sm font-medium text-gray-700">Al día</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="border-2 border-blue-200 px-4 py-4">
                                                    <textarea name="actividades[{{ $index }}][observacion]"
                                                              rows="3"
                                                              placeholder="Observaciones opcionales..."
                                                              disabled
                                                              class="w-full px-3 py-2 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('actividades.' . $index . '.observacion') }}</textarea>
                                                </td>
                                                <td class="border-2 border-blue-200 px-4 py-4">
                                                    <div class="flex flex-col items-center">
                                                        <canvas id="canvasPracticante_{{ $index }}"
                                                                class="border-2 border-blue-300 rounded-lg cursor-crosshair bg-white shadow-sm"
                                                                width="180"
                                                                height="80"
                                                                style="touch-action: none;"></canvas>
                                                        <input type="hidden" name="actividades[{{ $index }}][firma_practicante]" id="firmaPracticante_{{ $index }}" required>
                                                        <button type="button"
                                                                onclick="limpiarFirma({{ $index }})"
                                                                class="mt-2 text-xs text-red-600 hover:text-red-700 font-medium flex items-center">
                                                            @svg('heroicon-o-arrow-path', 'w-3 h-3 mr-1')
                                                            Limpiar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-6 bg-blue-100 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-information-circle', 'w-5 h-5 text-blue-700')
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-800">
                                                <strong>Instrucciones:</strong> Por favor, complete la fecha, marque el nivel de avance y firme en cada celda de la última columna para validar el monitoreo de cada actividad.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex flex-wrap justify-between items-center gap-4 pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('alumno.monitoreos-practicas.index', $semana) }}"
                               class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm group">
                                @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform')
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-800 to-blue-900 border-2 border-blue-800 rounded-xl text-white font-semibold hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                                @svg('heroicon-o-check-circle', 'w-5 h-5 mr-2 group-hover:rotate-12 transition-transform')
                                Guardar Monitoreo
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 rounded-lg p-6 shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @svg('heroicon-o-light-bulb', 'w-6 h-6 text-blue-600')
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-blue-800 mb-2">Información importante</h4>
                        <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                            <li>Debe completar la fecha para cada actividad</li>
                            <li>Debe firmar en cada actividad para validar el monitoreo</li>
                            <li>Marque el nivel de avance de cada actividad (Atrasado o Al día)</li>
                            <li>Las observaciones son opcionales pero recomendadas</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            // ==========================================
            // SISTEMA DE FIRMAS POR ACTIVIDAD
            // ==========================================
            const canvases = {};

            // Inicializar todos los canvas
            document.addEventListener('DOMContentLoaded', function() {
                @foreach($actividadesSemana as $index => $actividad)
                inicializarCanvas({{ $index }});
                @endforeach
            });

            function inicializarCanvas(index) {
                const canvasId = `canvasPracticante_${index}`;
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');

                canvases[index] = {
                    canvas: canvas,
                    ctx: ctx,
                    dibujando: false
                };

                // Configurar contexto
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                // Eventos mouse
                canvas.addEventListener('mousedown', (e) => iniciarDibujo(e, index));
                canvas.addEventListener('mousemove', (e) => dibujar(e, index));
                canvas.addEventListener('mouseup', () => detenerDibujo(index));
                canvas.addEventListener('mouseleave', () => detenerDibujo(index));

                // Eventos touch (móvil)
                canvas.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    iniciarDibujo(e.touches[0], index);
                });
                canvas.addEventListener('touchmove', (e) => {
                    e.preventDefault();
                    dibujar(e.touches[0], index);
                });
                canvas.addEventListener('touchend', (e) => {
                    e.preventDefault();
                    detenerDibujo(index);
                });
            }

            function obtenerPosicion(e, index) {
                const config = canvases[index];
                const rect = config.canvas.getBoundingClientRect();
                const scaleX = config.canvas.width / rect.width;
                const scaleY = config.canvas.height / rect.height;

                return {
                    x: (e.clientX - rect.left) * scaleX,
                    y: (e.clientY - rect.top) * scaleY
                };
            }

            function iniciarDibujo(e, index) {
                const config = canvases[index];
                config.dibujando = true;
                const pos = obtenerPosicion(e, index);
                config.ctx.beginPath();
                config.ctx.moveTo(pos.x, pos.y);
            }

            function dibujar(e, index) {
                const config = canvases[index];
                if (!config.dibujando) return;

                const pos = obtenerPosicion(e, index);
                config.ctx.lineTo(pos.x, pos.y);
                config.ctx.stroke();
            }

            function detenerDibujo(index) {
                const config = canvases[index];
                if (config.dibujando) {
                    config.dibujando = false;
                    guardarFirma(index);
                }
            }

            function guardarFirma(index) {
                const config = canvases[index];
                const dataURL = config.canvas.toDataURL('image/png');
                document.getElementById(`firmaPracticante_${index}`).value = dataURL;
            }

            function limpiarFirma(index) {
                const config = canvases[index];
                config.ctx.clearRect(0, 0, config.canvas.width, config.canvas.height);
                document.getElementById(`firmaPracticante_${index}`).value = '';
            }

            // ==========================================
            // VALIDACIÓN DEL FORMULARIO
            // ==========================================
            document.getElementById('formMonitoreo').addEventListener('submit', function(e) {
                let todasFirmadas = true;
                let mensajesError = [];

                // Validar todas las firmas y fechas
                @foreach($actividadesSemana as $index => $actividad)
                const canvas{{ $index }} = canvases[{{ $index }}].canvas;
                const ctx{{ $index }} = canvases[{{ $index }}].ctx;
                const pixelBuffer{{ $index }} = new Uint32Array(
                    ctx{{ $index }}.getImageData(0, 0, canvas{{ $index }}.width, canvas{{ $index }}.height).data.buffer
                );
                const hayFirma{{ $index }} = pixelBuffer{{ $index }}.some(color => color !== 0);

                if (!hayFirma{{ $index }}) {
                    todasFirmadas = false;
                    mensajesError.push(`Actividad ${{{ $index + 1 }}}: Falta la firma del practicante`);
                }

                const fecha{{ $index }} = document.querySelector('input[name="actividades[{{ $index }}][fecha]"]').value;
                if (!fecha{{ $index }}) {
                    todasFirmadas = false;
                    mensajesError.push(`Actividad ${{{ $index + 1 }}}: Falta la fecha`);
                }
                @endforeach

                if (!todasFirmadas) {
                    e.preventDefault();
                    alert('Por favor, complete todos los campos requeridos:\n\n' + mensajesError.join('\n'));
                    return false;
                }

                // Mostrar loading
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Guardando...';
            });
        </script>
    @endpush
</x-app-layout>
