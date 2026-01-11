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
                <a href="{{ route('profesor.monitoreos-practicas.download-pdf', $monitoreoPractica) }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                    @svg('heroicon-o-arrow-down-tray', 'w-5 h-5 mr-2')
                    Descargar PDF
                </a>
                <a href="{{ route('profesor.monitoreos-practicas.index', $monitoreoPractica->alumno) }}"
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

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-6 shadow-md">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @svg('heroicon-o-check-circle', 'w-6 h-6 text-green-600')
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-md">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @svg('heroicon-o-exclamation-triangle', 'w-6 h-6 text-red-600')
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

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

                    @php
                        // Verificar si hay actividades sin firmar del supervisor
                        $actividadesSinFirmar = $monitoreoPractica->monitoreosPracticasActividades->filter(function($actividad) {
                            return empty($actividad->firma_supervisor);
                        });
                        $hayActividadesSinFirmar = $actividadesSinFirmar->isNotEmpty();
                    @endphp

                    @if($hayActividadesSinFirmar)
                        <!-- Formulario de firmas -->
                        <form action="{{ route('profesor.monitoreos-practicas.update-firmas', $monitoreoPractica) }}"
                              method="POST"
                              id="formFirmas">
                            @csrf
                            @method('PUT')
                            @endif

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
                                                            @if($hayActividadesSinFirmar)
                                                                <div class="flex flex-col items-center">
                                                                    <canvas id="canvasSupervisor_{{ $index }}"
                                                                            class="border-2 border-blue-300 rounded-lg cursor-crosshair bg-white shadow-sm"
                                                                            width="180"
                                                                            height="80"
                                                                            style="touch-action: none;"></canvas>
                                                                    <input type="hidden" name="firmas[{{ $index }}][actividad_id]" value="{{ $actividad->id }}">
                                                                    <input type="hidden" name="firmas[{{ $index }}][firma_supervisor]" id="firmaSupervisor_{{ $index }}">
                                                                    <button type="button"
                                                                            onclick="limpiarFirma({{ $index }})"
                                                                            class="mt-2 text-xs text-red-600 hover:text-red-700 font-medium flex items-center">
                                                                        @svg('heroicon-o-arrow-path', 'w-3 h-3 mr-1')
                                                                        Limpiar
                                                                    </button>
                                                                </div>
                                                            @else
                                                                <span class="text-xs text-gray-400 italic">Pendiente</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($hayActividadesSinFirmar)
                                        <div class="mt-6 bg-blue-100 border border-blue-200 rounded-lg p-4">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    @svg('heroicon-o-information-circle', 'w-5 h-5 text-blue-700')
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm text-blue-800">
                                                        <strong>Instrucciones:</strong> Por favor, firme en cada celda pendiente para validar el monitoreo de las actividades que aún no tienen su firma.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($hayActividadesSinFirmar)
                                <!-- Botones de acción -->
                                <div class="flex flex-wrap justify-end items-center gap-4 pt-6 border-t-2 border-gray-200">
                                    <button type="submit"
                                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-800 to-blue-900 border-2 border-blue-800 rounded-xl text-white font-semibold hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                                        @svg('heroicon-o-check-circle', 'w-5 h-5 mr-2 group-hover:rotate-12 transition-transform')
                                        Guardar Firmas
                                    </button>
                                </div>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>

    @if($hayActividadesSinFirmar)
        @push('scripts')
            <script>
                // ==========================================
                // SISTEMA DE FIRMAS POR ACTIVIDAD
                // ==========================================
                const canvases = {};

                // Inicializar todos los canvas
                document.addEventListener('DOMContentLoaded', function() {
                    @foreach($monitoreoPractica->monitoreosPracticasActividades as $index => $actividad)
                    @if(empty($actividad->firma_supervisor))
                    inicializarCanvas({{ $index }});
                    @endif
                    @endforeach
                });

                function inicializarCanvas(index) {
                    const canvasId = `canvasSupervisor_${index}`;
                    const canvas = document.getElementById(canvasId);
                    if (!canvas) return;

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
                    document.getElementById(`firmaSupervisor_${index}`).value = dataURL;
                }

                function limpiarFirma(index) {
                    const config = canvases[index];
                    config.ctx.clearRect(0, 0, config.canvas.width, config.canvas.height);
                    document.getElementById(`firmaSupervisor_${index}`).value = '';
                }

                // ==========================================
                // VALIDACIÓN DEL FORMULARIO
                // ==========================================
                document.getElementById('formFirmas').addEventListener('submit', function(e) {
                    let todasFirmadas = true;
                    let mensajesError = [];

                    // Validar todas las firmas pendientes
                    @foreach($monitoreoPractica->monitoreosPracticasActividades as $index => $actividad)
                        @if(empty($actividad->firma_supervisor))
                    if (canvases[{{ $index }}]) {
                        const canvas{{ $index }} = canvases[{{ $index }}].canvas;
                        const ctx{{ $index }} = canvases[{{ $index }}].ctx;
                        const pixelBuffer{{ $index }} = new Uint32Array(
                            ctx{{ $index }}.getImageData(0, 0, canvas{{ $index }}.width, canvas{{ $index }}.height).data.buffer
                        );
                        const hayFirma{{ $index }} = pixelBuffer{{ $index }}.some(color => color !== 0);

                        if (!hayFirma{{ $index }}) {
                            todasFirmadas = false;
                            mensajesError.push(`Actividad ${{{ $index + 1 }}}: Falta la firma del supervisor`);
                        }
                    }
                    @endif
                        @endforeach

                    if (!todasFirmadas) {
                        e.preventDefault();
                        alert('Por favor, complete todas las firmas pendientes:\n\n' + mensajesError.join('\n'));
                        return false;
                    }

                    // Mostrar loading
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Guardando...';
                });
            </script>
@endpush
@endif
</x-app-layout>
