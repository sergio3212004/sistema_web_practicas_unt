<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-8">

            <!-- ENCABEZADO -->
            <div class="text-center mb-8 border-b pb-6">
                <h2 class="text-xl font-bold text-gray-800">FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS</h2>
                <h3 class="text-lg font-semibold text-gray-700 mt-2">PROGRAMA DE INFORMÁTICA</h3>
                <h4 class="text-md font-semibold text-gray-600 mt-2">MONITOREO DE PRÁCTICAS PRE PROFESIONALES</h4>
                <p class="text-sm text-gray-500 mt-2">FORMATO 01: FICHA DE REGISTRO</p>
            </div>

            <form action="{{ route('alumno.ficha-registro.store') }}" method="POST" id="fichaForm">
                @csrf

                <!-- =========================
                    1. ESTUDIANTE
                ========================== -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold bg-gray-100 p-3 rounded">1. ESTUDIANTE</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-4 mt-4">
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Apellidos y Nombres</label>
                            <input type="text" disabled
                                   value="{{ $alumno->nombre_completo }}"
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">N° Matrícula</label>
                            <input type="text" disabled
                                   value="{{ $alumno->codigo_matricula }}"
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Ciclo</label>
                            <input type="text" disabled
                                   value="{{ $alumno->aula->ciclo ?? 'N/A' }}"
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Semestre</label>
                            <input type="text" disabled
                                   value="{{ $semestreActivo->nombre }}"
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Teléfono</label>
                            <input type="text" disabled
                                   value="{{ $alumno->telefono }}"
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Correo</label>
                            <input type="text" disabled
                                   value="{{ $alumno->user->email }}"
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>
                    </div>
                </div>

                <!-- =========================
                    2. EMPRESA
                ========================== -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold bg-gray-100 p-3 rounded">2. EMPRESA / INSTITUCIÓN</h3>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">
                            Nombre de la Empresa *
                        </label>
                        <input type="text" name="nombre_empresa" required
                               class="w-full border rounded px-4 py-2">
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-4 mt-4">
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">
                                Razón Social *
                            </label>
                            <select name="razon_social_acronimo" required
                                    class="w-full border rounded px-4 py-2">
                                <option value="">-- Seleccione --</option>
                                @foreach($empresas as $razon)
                                    <option value="{{ $razon->acronimo }}">
                                        {{ $razon->acronimo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label class="text-sm font-medium">RUC</label>
                            <input type="text" id="ruc" name="ruc" required
                                   class="w-full bg-gray-100 border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Gerente General *</label>
                            <input type="text" name="nombre_gerente" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Jefe RRHH *</label>
                            <input type="text" name="nombre_jefe_rrhh" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Dirección *</label>
                            <input type="text" name="direccion" required
                                   class="w-full border rounded px-4 py-2">
                        </div>
                    </div>
                </div>

                <!-- =========================
                    3. PRÁCTICAS
                ========================== -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold bg-gray-100 p-3 rounded">
                        3. CARACTERÍSTICAS DE LA PRÁCTICA
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-4 mt-4">

                        <div>
                            <label class="text-sm font-medium">Fecha Inicio *</label>
                            <input type="date" name="fecha_inicio" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Fecha Término *</label>
                            <input type="date" name="fecha_termino" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Área de Prácticas *</label>
                            <input type="text" name="area_practicas" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Cargo del Practicante *</label>
                            <input type="text" name="cargo" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Descripción de Actividades *</label>
                            <textarea name="descripcion" rows="4" required
                                      class="w-full border rounded px-4 py-2"></textarea>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Jefe Directo *</label>
                            <input type="text" name="nombre_jefe_directo" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Teléfono Jefe Directo *</label>
                            <input type="text" name="telefono_jefe_directo" required
                                   class="w-full border rounded px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Correo Jefe Directo *</label>
                            <input type="email" name="correo_jefe_directo" required
                                   class="w-full border rounded px-4 py-2">
                        </div>
                    </div>

                    <!-- =========================
                        HORARIOS
                    ========================== -->
                    <div class="pl-4 mt-6">
                        <h4 class="font-semibold mb-2">Horario de Prácticas *</h4>

                        <table class="w-full border">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-3 py-2">Día</th>
                                <th class="border px-3 py-2">Inicio</th>
                                <th class="border px-3 py-2">Fin</th>
                                <th class="border px-3 py-2">Activo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($diasSemana as $dia => $nombre)
                                <tr>
                                    <td class="border px-3 py-2">{{ $nombre }}</td>

                                    <td class="border px-3 py-2">
                                        <input type="time"
                                               name="horarios[{{ $dia }}][hora_inicio]"
                                               id="hora_inicio_{{ $dia }}"
                                               disabled
                                               class="border rounded px-2 py-1 w-full">
                                    </td>

                                    <td class="border px-3 py-2">
                                        <input type="time"
                                               name="horarios[{{ $dia }}][hora_fin]"
                                               id="hora_fin_{{ $dia }}"
                                               disabled
                                               class="border rounded px-2 py-1 w-full">
                                    </td>

                                    <td class="border text-center">
                                        <input type="checkbox"
                                               class="dia-checkbox"
                                               data-dia="{{ $dia }}">
                                        <input type="hidden"
                                               name="horarios[{{ $dia }}][dia_semana]"
                                               value="{{ $dia }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- =========================
                    FIRMA
                ========================== -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold bg-gray-100 p-3 rounded">FIRMA DEL PRACTICANTE</h3>

                    <canvas id="signaturePad" width="600" height="200"
                            class="border rounded mt-4"></canvas>
                    <input type="hidden" name="firma_practicante" id="firma_practicante">

                    <button type="button" id="clearSignature"
                            class="mt-2 bg-red-500 text-white px-4 py-2 rounded">
                        Limpiar Firma
                    </button>
                </div>

                <!-- BOTONES -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('alumno.ficha-registro.index') }}"
                       class="bg-gray-300 px-6 py-2 rounded">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded">
                        Guardar Ficha
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const canvas = document.getElementById('signaturePad');
        const signaturePad = new SignaturePad(canvas);

        document.getElementById('clearSignature')
            .addEventListener('click', () => signaturePad.clear());

        document.getElementById('fichaForm')
            .addEventListener('submit', () => {
                if (!signaturePad.isEmpty()) {
                    document.getElementById('firma_practicante')
                        .value = signaturePad.toDataURL('image/png');
                }
            });

        document.querySelectorAll('.dia-checkbox').forEach(cb => {
            cb.addEventListener('change', function () {
                const dia = this.dataset.dia;
                document.getElementById(`hora_inicio_${dia}`).disabled = !this.checked;
                document.getElementById(`hora_fin_${dia}`).disabled = !this.checked;
            });
        });
    });

</script>
