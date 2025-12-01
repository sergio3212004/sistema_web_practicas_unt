@props(['empresa' => null, 'razonesSociales'])

<div id="empresa-data" class="space-y-6 mb-8 p-6 bg-green-50 rounded-lg border border-green-200 hidden">

    <h2 class="text-xl font-semibold text-green-700 border-b pb-2">Datos de la Empresa</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label>RUC</label>
            <input type="text" name="ruc"
                   value="{{ old('ruc', $empresa->ruc ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
        </div>

        <div>
            <label>Razón Social</label>
            <select name="razon_social_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                <option value="">Seleccione</option>
                @foreach ($razonesSociales as $rz)
                    <option value="{{ $rz->id }}"
                        @selected(old('razon_social_id', $empresa->razon_social_id ?? '') == $rz->id)>
                        {{ $rz->acronimo }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label>Nombre Comercial</label>
        <input type="text" name="nombre"
               value="{{ old('nombre', $empresa->nombre ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label>Departamento</label>
            <select id="departamento" name="departamento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                <option value="">{{ old('departamento', $empresa->departamento ?? '') }}</option>
            </select>
        </div>
        <div>
            <label>Provincia</label>
            <select id="provincia" name="provincia" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                <option value="">{{ old('provincia', $empresa->provincia ?? '') }}</option>
            </select>
        </div>
        <div>
            <label>Distrito</label>
            <select id="distrito" name="distrito" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                <option value="">{{ old('distrito', $empresa->distrito ?? '') }}</option>
            </select>
        </div>
    </div>

    <div>
        <label>Dirección</label>
        <input type="text" name="direccion"
               value="{{ old('direccion', $empresa->direccion ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
    </div>

    <div>
        <label>Teléfono</label>
        <input type="text" name="telefono"
               value="{{ old('telefono', $empresa->telefono ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
    </div>
</div>
