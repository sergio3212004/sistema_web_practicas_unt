<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Encabezado -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h1 class="text-2xl font-bold">PLAN DE PRÁCTICAS PRE-PROFESIONALES</h1>
                    <p class="text-sm mt-1">FORMATO 02: PLAN DE PRÁCTICAS</p>
                </div>

                <form id="formCronograma" action="{{ route('alumno.cronograma.store', $fichaRegistro) }}" method="POST" class="p-6">
                    @csrf

                    <!-- 1. ESTUDIANTE (Solo lectura) -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                            1. ESTUDIANTE
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos y Nombre</label>
                                <input type="text" value="{{ $fichaRegistro->alumno->nombre_completo }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nro. Matrícula</label>
                                <input type="text" value="{{ $fichaRegistro->alumno->codigo_matricula }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ciclo</label>
                                <input type="text" value="{{ $fichaRegistro->ciclo }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Año y Semestre</label>
                                <input type="text" value="{{ $fichaRegistro->semestre->nombre ?? 'N/A' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono Celular</label>
                                <input type="text" value="{{ $fichaRegistro->alumno->telefono }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                                <input type="text" value="{{ $fichaRegistro->alumno->user->email }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- 2. EMPRESA (Solo lectura) -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                            2. EMPRESA O INSTITUCIÓN
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Razón Social</label>
                                <input type="text" value="{{ $fichaRegistro->razon_social }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">RUC</label>
                                <input type="text" value="{{ $fichaRegistro->ruc }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gerente General</label>
                                <input type="text" value="{{ $fichaRegistro->nombre_gerente }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jefe de RRHH</label>
                                <input type="text" value="{{ $fichaRegistro->nombre_jefe_rrhh }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" value="{{ $fichaRegistro->direccion }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono Fijo</label>
                                <input type="text" value="{{ $fichaRegistro->telefono_fijo ?? 'N/A' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono Móvil</label>
                                <input type="text" value="{{ $fichaRegistro->telefono_movil }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Distrito</label>
                                <input type="text" value="{{ $fichaRegistro->distrito }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                                <input type="text" value="{{ $fichaRegistro->provincia }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CARACTERÍSTICAS (Solo lectura) -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                            3. CARACTERÍSTICAS DE LA PRÁCTICA
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                                <input type="text" value="{{ $fichaRegistro->fecha_inicio->format('d/m/Y') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Término</label>
                                <input type="text" value="{{ $fichaRegistro->fecha_termino->format('d/m/Y') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                        </div>

                        <!-- Horarios -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Días y Horario</label>
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300">
                                    <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2">Día</th>
                                        <th class="border border-gray-300 px-4 py-2">Horario</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                    @endphp
                                    @foreach($fichaRegistro->horarios as $horario)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2 font-medium">
                                                {{ $dias[$horario->dia_semana - 1] }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                De {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la práctica</label>
                                <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>{{ $fichaRegistro->descripcion }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Área o unidad donde se realizará la práctica</label>
                                <input type="text" value="{{ $fichaRegistro->area_practicas }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Jefe Directo</label>
                                <input type="text" value="{{ $fichaRegistro->nombre_jefe_directo }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo del Jefe</label>
                                <input type="text" value="{{ $fichaRegistro->cargo }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Celular de Jefe</label>
                                    <input type="text" value="{{ $fichaRegistro->telefono_jefe_directo }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo de Jefe</label>
                                    <input type="text" value="{{ $fichaRegistro->correo_jefe_directo }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. ACTIVIDADES PRINCIPALES (Editable) -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                            4. ACTIVIDADES PRINCIPALES A REALIZARSE EN LA PRÁCTICA
                        </h2>

                        <div id="contenedorActividades">
                            <!-- Actividad 1 (por defecto) -->
                            <div class="actividad-item mb-6 p-4 border border-gray-300 rounded-lg bg-gray-50" data-index="0">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="font-semibold text-lg text-gray-700">Actividad 1</h3>
                                    <button type="button" onclick="eliminarActividad(0)"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium hidden">
                                        Eliminar
                                    </button>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la actividad</label>
                                    <textarea name="actividades[0][nombre]" rows="2" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Describe la actividad a realizar..."></textarea>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full border border-gray-300 text-sm">
                                        <thead class="bg-gray-200">
                                        <tr>
                                            <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 1</th>
                                            <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 2</th>
                                            <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 3</th>
                                            <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 4</th>
                                        </tr>
                                        <tr>
                                            @for($i = 1; $i <= 4; $i++)
                                                @for($j = 1; $j <= 4; $j++)
                                                    <th class="border border-gray-300 px-2 py-1 bg-gray-100">S{{ $j }}</th>
                                                @endfor
                                            @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @for($mes = 1; $mes <= 4; $mes++)
                                                @for($semana = 1; $semana <= 4; $semana++)
                                                    <td class="border border-gray-300 px-2 py-2 text-center">
                                                        <input type="checkbox"
                                                               name="actividades[0][semanas][]"
                                                               value="m{{ $mes }}_s{{ $semana }}"
                                                               class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    </td>
                                                @endfor
                                            @endfor
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="agregarActividad()"
                                class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            + Agregar Actividad
                        </button>
                        <p class="text-sm text-gray-600 mt-2">Máximo 5 actividades</p>
                    </div>

                    <!-- Firma del Practicante -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                            FIRMA DEL PRACTICANTE
                        </h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Firme en el recuadro a continuación: <span class="text-red-600">*</span>
                            </label>
                            <div class="border-2 border-gray-400 rounded-lg overflow-hidden bg-white">
                                <canvas id="canvasFirma" width="600" height="200" class="w-full cursor-crosshair"></canvas>
                            </div>
                            <button type="button" onclick="limpiarFirma()"
                                    class="mt-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">
                                Limpiar Firma
                            </button>
                            <input type="hidden" name="firma_practicante" id="firmaPracticante">
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Nota:</strong> Una vez que firmes y envíes este cronograma, se enviarán correos electrónicos a:
                            </p>
                            <ul class="list-disc list-inside text-sm text-blue-700 mt-2 ml-4">
                                <li><strong>Jefe Directo:</strong> {{ $fichaRegistro->correo_jefe_directo }}</li>
                                <li><strong>Profesor Supervisor:</strong> {{ $fichaRegistro->alumno->aula->profesor->user->email }}</li>
                            </ul>
                            <p class="text-sm text-blue-700 mt-2">
                                Ellos recibirán un enlace para firmar digitalmente el cronograma.
                            </p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('alumno.ficha.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Crear Cronograma y Firmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let contadorActividades = 1;
    const maxActividades = 5;

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
        document.getElementById('firmaPracticante').value = '';
    }

    function agregarActividad() {
        if (contadorActividades >= maxActividades) {
            alert('Solo puedes agregar hasta 5 actividades');
            return;
        }

        const contenedor = document.getElementById('contenedorActividades');
        const index = contadorActividades;

        const actividadHTML = `
            <div class="actividad-item mb-6 p-4 border border-gray-300 rounded-lg bg-gray-50" data-index="${index}">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-lg text-gray-700">Actividad ${index + 1}</h3>
                    <button type="button" onclick="eliminarActividad(${index})"
                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Eliminar
                    </button>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la actividad</label>
                    <textarea name="actividades[${index}][nombre]" rows="2" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Describe la actividad a realizar..."></textarea>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 1</th>
                                <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 2</th>
                                <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 3</th>
                                <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 4</th>
                            </tr>
                            <tr>
                                ${Array(16).fill().map((_, i) => `<th class="border border-gray-300 px-2 py-1 bg-gray-100">S${(i % 4) + 1}</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                ${Array(4).fill().map((_, mes) =>
            Array(4).fill().map((_, sem) =>
                `<td class="border border-gray-300 px-2 py-2 text-center">
                                            <input type="checkbox"
                                                   name="actividades[${index}][semanas][]"
                                                   value="m${mes + 1}_s${sem + 1}"
                                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </td>`
            ).join('')
        ).join('')}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        contenedor.insertAdjacentHTML('beforeend', actividadHTML);
        contadorActividades++;
    }

    function eliminarActividad(index) {
        const actividad = document.querySelector(`[data-index="${index}"]`);
        if (actividad) {
            actividad.remove();
            contadorActividades--;
            // Renumerar actividades
            actualizarNumeracion();
        }
    }

    function actualizarNumeracion() {
        const actividades = document.querySelectorAll('.actividad-item');
        actividades.forEach((act, idx) => {
            const titulo = act.querySelector('h3');
            titulo.textContent = `Actividad ${idx + 1}`;
        });
    }

    // Validar formulario
    document.getElementById('formCronograma').addEventListener('submit', function(e) {
        // Guardar firma
        const firmaData = canvas.toDataURL('image/png');
        document.getElementById('firmaPracticante').value = firmaData;

        // Validar que haya firma
        const pixelBuffer = new Uint32Array(
            ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
        );
        const hayFirma = pixelBuffer.some(color => color !== 0);

        if (!hayFirma) {
            e.preventDefault();
            alert('Por favor, firma en el recuadro correspondiente');
            return false;
        }

        // Validar que cada actividad tenga al menos una semana marcada
        const actividades = document.querySelectorAll('.actividad-item');
        let todasValidas = true;

        actividades.forEach((act, idx) => {
            const checkboxes = act.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                todasValidas = false;
                alert(`La Actividad ${idx + 1} debe tener al menos una semana seleccionada`);
            }
        });

        if (!todasValidas) {
            e.preventDefault();
            return false;
        }
    });
</script>
