@props(['profesor' => null])

<div id="profesor-fields" class="hidden">
    <div class="space-y-6 bg-indigo-50 p-6 rounded-lg border border-indigo-200 mt-6">

        <h2 class="text-xl font-semibold text-indigo-700 border-b pb-2">Datos del Profesor</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700">Código Profesor</label>
            <input type="text" name="codigo_profesor"
                   value="{{ old('codigo_profesor') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                <input type="text" name="nombres_profesor" value="{{ old('nombres_profesor') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
                <input type="text" name="apellido_paterno_profesor" value="{{ old('apellido_paterno_profesor') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                <input type="text" name="apellido_materno_profesor" value="{{ old('apellido_materno_profesor') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="telefono_profesor" value="{{ old('telefono_profesor') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
            </div>
        </div>

    </div>
</div>
