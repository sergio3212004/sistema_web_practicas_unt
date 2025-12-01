@props(['admin' => null])

<div id="administrador-fields" class="hidden">
    <div class="space-y-6 bg-indigo-50 p-6 rounded-lg border border-indigo-200 mt-6">

        <h2 class="text-xl font-semibold text-indigo-700 border-b pb-2">
            Datos del Administrador
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                <input type="text" name="nombres_admin"
                       value="{{ old('nombres_admin', $admin->nombres ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Teléfono (opcional)</label>
                <input type="text" name="telefono_admin"
                       value="{{ old('telefono_admin', $admin->telefono ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
                <input type="text" name="apellido_paterno_admin"
                       value="{{ old('apellido_paterno_admin', $admin->apellido_paterno ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                <input type="text" name="apellido_materno_admin"
                       value="{{ old('apellido_materno_admin', $admin->apellido_materno ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>
        </div>

    </div>
</div>
