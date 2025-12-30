<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firma de Cronograma - Plan de Prácticas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h1 class="text-2xl font-bold">Firma de Plan de Prácticas</h1>
                <p class="text-sm mt-1">
                    @if($firmaToken->tipo === 'jefe_directo')
                        Firma como Jefe Directo
                    @elseif($firmaToken->tipo === 'profesor')
                        Firma como Profesor Supervisor
                    @endif
                </p>
            </div>

            <div class="p-6">
                <!-- Información del Estudiante -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">Información del Practicante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="font-medium">Estudiante:</span>
                            {{ $cronograma->fichaRegistro->alumno->nombre_completo }}
                        </div>
                        <div>
                            <span class="font-medium">Empresa:</span>
                            {{ $cronograma->fichaRegistro->razon_social }}
                        </div>
                        <div>
                            <span class="font-medium">Período:</span>
                            {{ $cronograma->fichaRegistro->fecha_inicio->format('d/m/Y') }} -
                            {{ $cronograma->fichaRegistro->fecha_termino->format('d/m/Y') }}
                        </div>
                        <div>
                            <span class="font-medium">Área:</span>
                            {{ $cronograma->fichaRegistro->area_practicas }}
                        </div>
                    </div>
                </div>

                <!-- Actividades del Cronograma -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-3">Actividades Programadas</h3>

                    @foreach($cronograma->actividades as $index => $actividad)
                        <div class="mb-4 p-3 border border-gray-300 rounded-lg bg-gray-50">
                            <h4 class="font-medium text-gray-800 mb-2">
                                Actividad {{ $index + 1 }}: {{ $actividad->actividad }}
                            </h4>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs border border-gray-300">
                                    <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border px-2 py-1" colspan="4">Mes 1</th>
                                        <th class="border px-2 py-1" colspan="4">Mes 2</th>
                                        <th class="border px-2 py-1" colspan="4">Mes 3</th>
                                        <th class="border px-2 py-1" colspan="4">Mes 4</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @for($mes = 1; $mes <= 4; $mes++)
                                            @for($semana = 1; $semana <= 4; $semana++)
                                                @php
                                                    $campo = "m{$mes}_s{$semana}";
                                                    $marcado = $actividad->$campo;
                                                @endphp
                                                <td class="border px-2 py-1 text-center {{ $marcado ? 'bg-green-100' : '' }}">
                                                    @if($marcado)
                                                        <span class="text-green-600 font-bold">✓</span>
                                                    @else
                                                        <span class="text-gray-300">-</span>
                                                    @endif
                                                </td>
                                            @endfor
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Formulario de Firma -->
                <form method="POST" action="{{ route('firma.cronograma.firmar', $firmaToken->token) }}" id="formFirma">
                    @csrf

                    <div class="mb-6 p-4 border-2 border-blue-500 rounded-lg bg-blue-50">
                        <h3 class="font-semibold text-lg mb-3">Tu Firma Digital</h3>
                        <p class="text-sm text-gray-700 mb-3">
                            Dibuja tu firma en el recuadro a continuación:
                        </p>

                        <div class="border-2 border-gray-400 rounded-lg overflow-hidden bg-white">
                            <canvas id="canvasFirma" width="600" height="200"
                                    class="w-full cursor-crosshair"></canvas>
                        </div>

                        <button type="button" onclick="limpiarFirma()"
                                class="mt-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">
                            Limpiar Firma
                        </button>

                        <input type="hidden" name="firma" id="firmaInput">
                    </div>

                    <!-- Checkbox de Aceptación -->
                    <div class="mb-6">
                        <label class="flex items-start space-x-3">
                            <input type="checkbox" name="acepto" required
                                   class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">
                                    Confirmo que he revisado el cronograma de actividades y estoy de acuerdo
                                    con las actividades y plazos establecidos. Mi firma digital tiene el mismo
                                    valor legal que una firma manuscrita.
                                </span>
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700
                                           focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
                            Firmar Cronograma
                        </button>
                    </div>
                </form>

                <!-- Información de Expiración -->
                <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <strong>Nota:</strong> Este enlace expira el
                        <strong>{{ $firmaToken->expires_at->format('d/m/Y') }} a las {{ $firmaToken->expires_at->format('H:i') }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Canvas para firma
    const canvas = document.getElementById('canvasFirma');
    const ctx = canvas.getContext('2d');
    let dibujando = false;

    canvas.addEventListener('mousedown', iniciarDibujo);
    canvas.addEventListener('mousemove', dibujar);
    canvas.addEventListener('mouseup', detenerDibujo);
    canvas.addEventListener('mouseout', detenerDibujo);

    // Touch events para móviles
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    });

    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    });

    canvas.addEventListener('touchend', (e) => {
        e.preventDefault();
        const mouseEvent = new MouseEvent('mouseup', {});
        canvas.dispatchEvent(mouseEvent);
    });

    function iniciarDibujo(e) {
        dibujando = true;
        const rect = canvas.getBoundingClientRect();
        ctx.beginPath();
        ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
    }

    function dibujar(e) {
        if (!dibujando) return;
        const rect = canvas.getBoundingClientRect();
        ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.stroke();
    }

    function detenerDibujo() {
        dibujando = false;
    }

    function limpiarFirma() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('firmaInput').value = '';
    }

    // Validar y guardar firma
    document.getElementById('formFirma').addEventListener('submit', function(e) {
        const firmaData = canvas.toDataURL('image/png');
        document.getElementById('firmaInput').value = firmaData;

        // Validar que haya firma
        const pixelBuffer = new Uint32Array(
            ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
        );
        const hayFirma = pixelBuffer.some(color => color !== 0);

        if (!hayFirma) {
            e.preventDefault();
            alert('Por favor, firma en el recuadro antes de continuar');
            return false;
        }
    });
</script>
</body>
</html>
