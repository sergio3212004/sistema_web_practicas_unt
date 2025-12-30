<x-app-layout>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                    {{-- ENCABEZADO --}}
                    <div class="text-center mb-8 border-b pb-6">
                        <h1 class="text-xl font-bold text-gray-800">
                            FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS
                        </h1>
                        <h2 class="text-lg font-semibold text-gray-700 mt-1">
                            PROGRAMA DE INFORMÁTICA
                        </h2>
                        <h3 class="text-md font-medium text-gray-600 mt-2">
                            MONITOREO DE PRÁCTICAS PRE PROFESIONALES
                        </h3>
                        <p class="text-sm text-gray-500 mt-2">
                            FORMATO 01: FICHA DE REGISTRO
                        </p>
                    </div>

                    {{-- 1. ESTUDIANTE --}}
                    <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">1. ESTUDIANTE</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Apellidos y Nombres
                            </label>
                            <div class="campo">
                                {{ $fichaRegistro->alumno->nombre_completo }}
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="label">Nro. Matrícula</label>
                                <div class="campo">
                                    {{ $fichaRegistro->alumno->codigo_matricula }}
                                </div>
                            </div>
                            <div>
                                <label class="label">Ciclo</label>
                                <div class="campo">
                                    {{ $fichaRegistro->ciclo }}
                                </div>
                            </div>
                            <div>
                                <label class="label">Semestre</label>
                                <div class="campo">
                                    {{ $fichaRegistro->semestre->nombre }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">Teléfono</label>
                                <div class="campo">
                                    {{ $fichaRegistro->alumno->telefono }}
                                </div>
                            </div>
                            <div>
                                <label class="label">Correo</label>
                                <div class="campo">
                                    {{ $fichaRegistro->alumno->user->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. EMPRESA --}}
                    <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            2. EMPRESA O INSTITUCIÓN
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="label">Razón Social</label>
                                <div class="campo">
                                    {{ $fichaRegistro->razon_social }}
                                </div>
                            </div>
                            <div>
                                <label class="label">RUC</label>
                                <div class="campo">
                                    {{ $fichaRegistro->ruc }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="label">Gerente General</label>
                                <div class="campo">
                                    {{ $fichaRegistro->nombre_gerente }}
                                </div>
                            </div>
                            <div>
                                <label class="label">Jefe RRHH</label>
                                <div class="campo">
                                    {{ $fichaRegistro->nombre_jefe_rrhh }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="label">Dirección</label>
                            <div class="campo">
                                {{ $fichaRegistro->direccion }}
                            </div>
                        </div>
                    </div>

                    {{-- 3. PRÁCTICA --}}
                    <div class="mb-8 border-2 border-gray-300 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            3. CARACTERÍSTICAS DE LA PRÁCTICA
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="label">Fecha de Inicio</label>
                                <div class="campo">
                                    {{ $fichaRegistro->fecha_inicio->format('d/m/Y') }}
                                </div>
                            </div>
                            <div>
                                <label class="label">Fecha de Término</label>
                                <div class="campo">
                                    {{ $fichaRegistro->fecha_termino->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="label">Descripción</label>
                            <div class="campo">
                                {{ $fichaRegistro->descripcion }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">Área de Prácticas</label>
                                <div class="campo">
                                    {{ $fichaRegistro->area_practicas }}
                                </div>
                            </div>
                            <div>
                                <label class="label">Cargo</label>
                                <div class="campo">
                                    {{ $fichaRegistro->cargo }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 4. FIRMAS --}}
                    <div class="mt-10 border-2 border-gray-300 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">
                            4. FIRMAS
                        </h3>

                        <div class="grid grid-cols-3 gap-8 text-center">

                            {{-- FIRMA EMPRESA --}}
                            <div>
                                <p class="text-sm font-semibold mb-2">Empresa</p>

                                <div class="h-32 flex items-center justify-center border-b border-gray-400 mb-2">
                                    @if($fichaRegistro->firma_empresa)
                                        <img
                                            src="{{ asset('storage/firmas/' . $fichaRegistro->firma_empresa) }}"
                                            alt="Firma Empresa"
                                            class="max-h-28 mx-auto"
                                        >
                                    @else
                                        <span class="text-gray-400 text-sm">No firmada</span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-500">
                                    Representante Legal
                                </p>
                            </div>

                            {{-- FIRMA PROGRAMA --}}
                            <div>
                                <p class="text-sm font-semibold mb-2">Programa</p>

                                <div class="h-32 flex items-center justify-center border-b border-gray-400 mb-2">
                                    @if($fichaRegistro->firma_programa)
                                        <img
                                            src="{{ asset('storage/firmas/' . $fichaRegistro->firma_programa) }}"
                                            alt="Firma Programa"
                                            class="max-h-28 mx-auto"
                                        >
                                    @else
                                        <span class="text-gray-400 text-sm">No firmada</span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-500">
                                    Coordinador de Prácticas
                                </p>
                            </div>

                            {{-- FIRMA PRACTICANTE --}}
                            <div>
                                <p class="text-sm font-semibold mb-2">Practicante</p>

                                <div class="h-32 flex items-center justify-center border-b border-gray-400 mb-2">
                                    @if($fichaRegistro->firma_practicante)
                                        <img
                                            src="{{ asset('storage/firmas/' . $fichaRegistro->firma_practicante) }}"
                                            alt="Firma Practicante"
                                            class="max-h-28 mx-auto"
                                        >
                                    @else
                                        <span class="text-gray-400 text-sm">No firmada</span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-500">
                                    Alumno
                                </p>
                            </div>

                        </div>
                    </div>


                    {{-- BOTONES --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ url()->previous() }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Volver
                        </a>

                        @if(!$fichaRegistro->aceptado)
                            <form method="POST"
                                  action="{{ route('profesor.fichas.aceptar', $fichaRegistro) }}"
                                  onsubmit="return confirm('¿Aceptar esta ficha de registro?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Aceptar ficha
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
