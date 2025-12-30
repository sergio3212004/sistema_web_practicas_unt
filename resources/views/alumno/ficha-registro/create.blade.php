<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Ficha de Registro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Encabezado del formulario -->
                    <div class="text-center mb-8 border-b pb-6">
                        <h1 class="text-xl font-bold text-gray-800">FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS</h1>
                        <h2 class="text-lg font-semibold text-gray-700 mt-1">PROGRAMA DE INFORMÁTICA</h2>
                        <h3 class="text-md font-medium text-gray-600 mt-2">MONITOREO DE PRÁCTICAS PRE PROFESIONALES</h3>
                        <p class="text-sm text-gray-500 mt-2">FORMATO 01: FICHA DE REGISTRO</p>
                    </div>

                    <form method="POST" action="{{ route('alumno.ficha-registro.store') }}" id="formFicha">
                        @csrf

                        <!-- 1. ESTUDIANTE -->
                        <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">1. ESTUDIANTE:</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos y Nombre:</label>
                                <input type="text"
                                       value="{{ $alumno->nombre_completo }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                            </div>

                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nro. Matrícula:</label>
                                    <input type="text"
                                           value="{{ $alumno->codigo_matricula }}"
                                           disabled
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciclo: <span class="text-red-500">*</span></label>
                                    <input type="number"
                                           name="ciclo"
                                           min="1"
                                           max="10"
                                           value="{{ old('ciclo') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Año y Semestre:
                                    </label>

                                    <input type="text"
                                           value="{{ $semestreActual->nombre }}"
                                           disabled
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">

                                    <input type="hidden" name="semestre_id" value="{{ $semestreActual->id }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Telf. Celular:</label>
                                    <input type="text"
                                           value="{{ $alumno->telefono }}"
                                           disabled
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo:</label>
                                    <input type="email"
                                           value="{{ $alumno->user->email }}"
                                           disabled
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                </div>
                            </div>
                        </div>

                        <!-- 2. EMPRESA O INSTITUCIÓN -->
                        <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">2. EMPRESA O INSTITUCIÓN:</h3>

                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Empresa: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="nombre_empresa"
                                           value="{{ old('nombre_empresa') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Razón Social: <span class="text-red-500">*</span></label>
                                    <select name="razon_social_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccione</option>
                                        @foreach($razonesSociales as $razon)
                                            <option value="{{ $razon->id }}" {{ old('razon_social_id') == $razon->id ? 'selected' : '' }}>
                                                {{ $razon->acronimo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="block text-sm font-medium text-gray-700 mb-2">
                                <label for="correo_empresa" class="form-label">
                                    Correo electrónico de la empresa: <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="correo_empresa"
                                    id="correo_empresa"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 form-control @error('correo_empresa') is-invalid @enderror"
                                    value="{{ old('correo_empresa') }}"
                                    required
                                >
                            </div>


                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">RUC: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="ruc"
                                           maxlength="11"
                                           pattern="[0-9]{11}"
                                           value="{{ old('ruc') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gerente General: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="nombre_gerente"
                                           value="{{ old('nombre_gerente') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jefe de RRHH: <span class="text-red-500">*</span></label>
                                <input type="text"
                                       name="nombre_jefe_rrhh"
                                       value="{{ old('nombre_jefe_rrhh') }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dirección: <span class="text-red-500">*</span></label>
                                <input type="text"
                                       name="direccion"
                                       value="{{ old('direccion') }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Telf. Fijo: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="telefono_fijo"
                                           value="{{ old('telefono_fijo') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Telf. Celular: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="telefono_movil"
                                           value="{{ old('telefono_movil') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Departamento <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="departamento"
                                        id="departamento"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Provincia <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="provincia"
                                        id="provincia"
                                        required
                                        disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-100">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Distrito <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="distrito"
                                        id="distrito"
                                        required
                                        disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-100">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- 3. CARACTERÍSTICAS DE LA PRÁCTICA -->
                        <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">3. CARACTERÍSTICAS DE LA PRÁCTICA:</h3>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio: <span class="text-red-500">*</span></label>
                                    <input type="date"
                                           name="fecha_inicio"
                                           value="{{ old('fecha_inicio') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Término: <span class="text-red-500">*</span></label>
                                    <input type="date"
                                           name="fecha_termino"
                                           value="{{ old('fecha_termino') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- HORARIOS -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Días y Horario: <span class="text-red-500">*</span></label>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full border border-gray-300">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th class="border border-gray-300 px-2 py-2 text-xs font-medium">LUNES</th>
                                            <th class="border border-gray-300 px-2 py-2 text-xs font-medium">MARTES</th>
                                            <th class="border border-gray-300 px-2 py-2 text-xs font-medium">MIÉRCOLES</th>
                                            <th class="border border-gray-300 px-2 py-2 text-xs font-medium">JUEVES</th>
                                            <th class="border border-gray-300 px-2 py-2 text-xs font-medium">VIERNES</th>
                                            <th class="border border-gray-300 px-2 py-2 text-xs font-medium">SÁBADO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            @for($dia = 1; $dia <= 6; $dia++)
                                                <td class="border border-gray-300 px-2 py-3">
                                                    <div class="flex items-center mb-2">
                                                        <input type="checkbox"
                                                               id="dia_{{ $dia }}"
                                                               onchange="toggleHorario({{ $dia }})"
                                                               class="mr-2">
                                                        <label for="dia_{{ $dia }}" class="text-xs">Activar</label>
                                                    </div>
                                                    <div id="horario_{{ $dia }}" class="hidden">
                                                        <label class="block text-xs text-gray-600 mb-1">De:</label>
                                                        <input type="time"
                                                               name="horarios[{{ $dia }}][hora_inicio]"
                                                               class="w-full px-1 py-1 text-xs border border-gray-300 rounded mb-2">
                                                        <label class="block text-xs text-gray-600 mb-1">A:</label>
                                                        <input type="time"
                                                               name="horarios[{{ $dia }}][hora_fin]"
                                                               class="w-full px-1 py-1 text-xs border border-gray-300 rounded">
                                                        <input type="hidden"
                                                               name="horarios[{{ $dia }}][dia_semana]"
                                                               value="{{ $dia }}">
                                                    </div>
                                                </td>
                                            @endfor
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la práctica: <span class="text-red-500">*</span></label>
                                <textarea name="descripcion"
                                          rows="4"
                                          required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Área de prácticas: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="area_practicas"
                                           value="{{ old('area_practicas') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cargo: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="cargo"
                                           value="{{ old('cargo') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jefe Directo: <span class="text-red-500">*</span></label>
                                <input type="text"
                                       name="nombre_jefe_directo"
                                       value="{{ old('nombre_jefe_directo') }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Celular de Jefe Directo: <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           name="telefono_jefe_directo"
                                           value="{{ old('telefono_jefe_directo') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo de Jefe Directo: <span class="text-red-500">*</span></label>
                                    <input type="email"
                                           name="correo_jefe_directo"
                                           value="{{ old('correo_jefe_directo') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- FIRMAS -->
                        <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">FIRMAS:</h3>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-700 mb-2">VB° de la Empresa</p>
                                    <div class="h-24 border-2 border-dashed border-gray-300 rounded bg-gray-50 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Pendiente</span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Firma del Practicante <span class="text-red-500">*</span></p>
                                    <canvas id="canvasFirma"
                                            class="border-2 border-gray-300 rounded cursor-crosshair mx-auto"
                                            width="200"
                                            height="96">
                                    </canvas>
                                    <input type="hidden" name="firma_practicante" id="firmaPracticante">
                                    <button type="button"
                                            onclick="limpiarFirma()"
                                            class="mt-2 text-xs text-blue-600 hover:text-blue-800">
                                        Limpiar firma
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-700 mb-2">VB° del Programa</p>
                                    <div class="h-24 border-2 border-dashed border-gray-300 rounded bg-gray-50 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Pendiente</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BOTONES -->
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('alumno.ficha.index') }}"
                               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Guardar Ficha de Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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

            function toggleHorario(dia) {
                const checkbox = document.getElementById('dia_' + dia);
                const horarioDiv = document.getElementById('horario_' + dia);
                const inputs = horarioDiv.querySelectorAll('input[type="time"]');

                if (checkbox.checked) {
                    horarioDiv.classList.remove('hidden');
                    inputs.forEach(input => input.required = true);
                } else {
                    horarioDiv.classList.add('hidden');
                    inputs.forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                }
            }

            // Validar formulario
            document.getElementById('formFicha').addEventListener('submit', function(e) {
                // Guardar firma
                const firmaData = canvas.toDataURL('image/png');
                document.getElementById('firmaPracticante').value = firmaData;

                // Validar que haya firma
                const ctx = canvas.getContext('2d');
                const pixelBuffer = new Uint32Array(
                    ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
                );
                const hayFirma = pixelBuffer.some(color => color !== 0);

                if (!hayFirma) {
                    e.preventDefault();
                    alert('Por favor, firma en el recuadro correspondiente');
                    return false;
                }

                // Validar que al menos un horario esté seleccionado
                const horariosActivos = Array.from({length: 6}, (_, i) => i + 1)
                    .filter(dia => document.getElementById('dia_' + dia).checked);

                if (horariosActivos.length === 0) {
                    e.preventDefault();
                    alert('Debes seleccionar al menos un día de práctica');
                    return false;
                }

                // Remover horarios no seleccionados del formulario
                for (let dia = 1; dia <= 6; dia++) {
                    if (!document.getElementById('dia_' + dia).checked) {
                        const inputs = document.querySelectorAll(`[name^="horarios[${dia}]"]`);
                        inputs.forEach(input => input.remove());
                    }
                }
            });

            document.addEventListener('DOMContentLoaded', async function () {

                const departamentoSelect = document.getElementById("departamento");
                const provinciaSelect = document.getElementById("provincia");
                const distritoSelect = document.getElementById("distrito");

                let ubigeo = [];

                try {
                    ubigeo = await fetch("{{ asset('ubigeo.json') }}")
                        .then(res => res.json());
                } catch (error) {
                    console.error("Error cargando ubigeo.json:", error);
                    return;
                }

                // Cargar departamentos
                ubigeo.forEach(dep => {
                    const option = document.createElement("option");
                    option.value = dep.nombre;
                    option.textContent = dep.nombre;
                    departamentoSelect.appendChild(option);
                });

                // Cambio de departamento
                departamentoSelect.addEventListener("change", () => {
                    provinciaSelect.innerHTML = '<option value="">Seleccione</option>';
                    distritoSelect.innerHTML = '<option value="">Seleccione</option>';
                    provinciaSelect.disabled = true;
                    distritoSelect.disabled = true;

                    const dep = ubigeo.find(d => d.nombre === departamentoSelect.value);
                    if (!dep) return;

                    dep.provincias.forEach(prov => {
                        const option = document.createElement("option");
                        option.value = prov.nombre;
                        option.textContent = prov.nombre;
                        provinciaSelect.appendChild(option);
                    });

                    provinciaSelect.disabled = false;
                    provinciaSelect.classList.remove('bg-gray-100');
                });

                // Cambio de provincia
                provinciaSelect.addEventListener("change", () => {
                    distritoSelect.innerHTML = '<option value="">Seleccione</option>';
                    distritoSelect.disabled = true;

                    const dep = ubigeo.find(d => d.nombre === departamentoSelect.value);
                    if (!dep) return;

                    const prov = dep.provincias.find(p => p.nombre === provinciaSelect.value);
                    if (!prov) return;

                    prov.distritos.forEach(dist => {
                        const option = document.createElement("option");
                        option.value = dist;
                        option.textContent = dist;
                        distritoSelect.appendChild(option);
                    });

                    distritoSelect.disabled = false;
                    distritoSelect.classList.remove('bg-gray-100');
                });
            });
        </script>

    @endpush
</x-app-layout>
