<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Crear Usuario
        </h2>
    </x-slot>

    <div x-data="{ rolSeleccionado: '' }" class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg p-6">

                <form action="{{ route('admin.usuarios.store') }}" method="POST">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" name="email" required
                               class="w-full border-gray-300 rounded">
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Contraseña</label>
                        <input type="password" name="password" required
                               class="w-full border-gray-300 rounded">
                    </div>

                    {{-- Selección de Rol --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Rol</label>

                        <select name="rol_id" required
                                x-model="rolSeleccionado"
                                class="w-full border-gray-300 rounded">
                            <option value="">Seleccione un rol</option>

                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ ucfirst($rol->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- FORMULARIO PARA ALUMNO -->
                    <template x-if="rolSeleccionado == '1'">
                        <div class="border p-4 rounded mb-4 bg-gray-50">
                            <h3 class="font-semibold text-gray-700 mb-2">Datos de Alumno</h3>

                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-gray-700">Código Matrícula</label>
                                    <input type="text" name="codigo_matricula"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Teléfono</label>
                                    <input type="text" name="telefono"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Nombres</label>
                                    <input type="text" name="nombres"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Apellido Materno</label>
                                    <input type="text" name="apellido_materno"
                                           class="w-full border-gray-300 rounded">
                                </div>

                            </div>
                        </div>
                    </template>


                    <!-- FORMULARIO PARA ADMINISTRADOR -->
                    <template x-if="rolSeleccionado == '5'">
                        <div class="border p-4 rounded mb-4 bg-gray-50">
                            <h3 class="font-semibold text-gray-700 mb-2">Datos de Administrador</h3>

                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-gray-700">Nombres</label>
                                    <input type="text" name="nombres"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Apellido Materno</label>
                                    <input type="text" name="apellido_materno"
                                           class="w-full border-gray-300 rounded">
                                </div>

                                <div>
                                    <label class="block text-gray-700">Teléfono</label>
                                    <input type="text" name="telefono"
                                           class="w-full border-gray-300 rounded">
                                </div>

                            </div>
                        </div>
                    </template>



                    <!-- BOTÓN -->
                    <div class="mt-6 text-right">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Guardar Usuario
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
