<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl my-4 sm:my-8 max-h-[90vh] overflow-y-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Crear Nuevo Usuario</h1>
        <a href="{{ route('admin.usuarios.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr; Volver al Listado</a>

        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf

            <!-- Errores -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">¡Ocurrió un error!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Datos de Acceso -->
            <div class="space-y-6 mb-8 p-6 bg-indigo-50 rounded-lg border border-indigo-200">
                <h2 class="text-xl font-semibold text-indigo-700 border-b pb-2">Datos de Acceso</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rol del Usuario</label>
                    <select name="rol_id" id="rol_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        <option value="">Seleccione un Rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}" data-rol-nombre="{{ $rol->nombre }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Formularios según rol -->
            <div id="perfil-data" class="hidden">
                <x-alumno-form />
                <x-administrador-form />
                <x-empresa-form :usuario="$usuario ?? null" :razonesSociales="$razonesSociales"/>
                <x-profesor-form />
            </div>

            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-lg">Crear Usuario</button>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", async () => {

        /* ============================================================
           1) CONTROL DINÁMICO DE FORMULARIOS SEGÚN ROL
           ============================================================ */

        const rolSelect = document.getElementById("rol_id");
        const perfilData = document.getElementById("perfil-data");

        const formularios = document.querySelectorAll("#perfil-data > div[id$='-fields'], #perfil-data > div[id$='-data']");

        const mostrarCamposSegunRol = () => {
            const rolNombre = rolSelect.options[rolSelect.selectedIndex]?.dataset.rolNombre;

            // Oculta todo si no hay rol
            if (!rolNombre) {
                perfilData.classList.add("hidden");
                formularios.forEach(f => f.classList.add("hidden"));
                return;
            }

            perfilData.classList.remove("hidden");

            formularios.forEach(f => {
                const esFormularioDelRol =
                    f.id === `${rolNombre}-fields` || f.id === `${rolNombre}-data`;

                f.classList.toggle("hidden", !esFormularioDelRol);
            });
        };

        rolSelect.addEventListener("change", mostrarCamposSegunRol);
        mostrarCamposSegunRol();



        /* ============================================================
           2) UBIGEO DINÁMICO (Departamento → Provincia → Distrito)
           ============================================================ */

        const departamentoSelect = document.getElementById("departamento");
        const provinciaSelect = document.getElementById("provincia");
        const distritoSelect = document.getElementById("distrito");

        // Si no existe formulario de empresa, parar aquí
        if (!departamentoSelect) return;

        let ubigeo = [];
        try {
            ubigeo = await fetch("{{ asset('ubigeo.json') }}").then(res => res.json());
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

        // Cambia provincias al seleccionar departamento
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
        });

        // Cambia distritos al seleccionar provincia
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
        });
    });
</script>
