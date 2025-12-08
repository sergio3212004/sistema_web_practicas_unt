@props(['administrador', 'semestres'])

<h3 class="text-2xl font-bold mb-4">
    Bienvenido, {{ $administrador->nombre_completo }} (Administrador)
</h3>

<p class="mb-6">{{ __("Aquí puedes gestionar los semestres del sistema.") }}</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Seleccionable de Semestres y Cierre --}}
    <div class="p-4 border rounded-lg shadow-md">
        <h4 class="font-semibold text-lg mb-3">Gestión de Semestres</h4>
        <form method="POST" action="{{ route('admin.semestre.cerrar') }}" class="space-y-4">
            @csrf
            <label for="semestre_activo" class="block font-medium text-sm text-gray-700">
                Semestre Actual:
            </label>
            {{-- El Semestre activo actual debe venir seleccionado por defecto --}}
            <select name="semestre_id" id="semestre_activo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @foreach ($semestres as $semestre)
                    <option value="{{ $semestre->id }}" @selected($semestre->activo)>
                        {{ $semestre->nombre }} @if($semestre->activo) (Activo) @endif
                    </option>
                @endforeach
            </select>

            {{-- Botón para cerrar el semestre seleccionado --}}
            <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                Cerrar Semestre Seleccionado
            </button>
        </form>
    </div>

    {{-- Formulario para Agregar Nuevo Semestre --}}
    <div class="p-4 border rounded-lg shadow-md">
        <h4 class="font-semibold text-lg mb-3">Agregar Nuevo Semestre</h4>
        <form method="POST" action="{{ route('admin.semestre.nuevo') }}" class="space-y-4">
            @csrf

            {{-- El año se puede auto-calcular o dejar que el usuario lo ingrese --}}

            <label for="anio" class="block font-medium text-sm text-gray-700">Año:</label>
            <input type="number" name="anio" id="anio" value="{{ date('Y') }}" required
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">

            <label for="periodo" class="block font-medium text-sm text-gray-700">Período:</label>
            <select name="periodo" id="periodo" required
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                <option value="I">I (Enero - Junio)</option>
                <option value="II">II (Julio - Diciembre)</option>
                <option value="EXT">EXT (Extraordinario)</option>
            </select>

            {{-- Al crear uno nuevo, automáticamente se activará y desactivará los demás por la lógica del modelo Semestre --}}
            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                Crear y Activar Nuevo Semestre
            </button>
        </form>
    </div>

    {{-- 🎁 Espacio para otras acciones del administrador --}}
    <div class="p-4 border rounded-lg shadow-md flex items-center justify-center">
        <p class="text-center text-gray-500">Otras herramientas de administración...</p>
    </div>

</div>
