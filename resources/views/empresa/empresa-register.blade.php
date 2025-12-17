<x-guest-layout>
    <!-- Register Form - Empresa (Hidden by default) -->
    <form id="registerForm" method="POST" action="{{ route('empresa.register') }}" >
        @csrf

        <!-- RUC -->
        <div>
            <x-input-label for="ruc" value="RUC *" />
            <x-text-input
                id="ruc"
                class="block mt-1 w-full"
                type="text"
                name="ruc"
                :value="old('ruc')"
                required
                maxlength="11"
                pattern="[0-9]{11}"
                placeholder="11 dígitos" />
            <x-input-error :messages="$errors->get('ruc')" class="mt-2" />
        </div>

        <!-- Nombre de la Empresa -->
        <div class="mt-4">
            <x-input-label for="nombre" value="Nombre de la Empresa *" />
            <x-text-input
                id="nombre"
                class="block mt-1 w-full"
                type="text"
                name="nombre"
                :value="old('nombre')"
                required />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Razón Social -->
        <div class="mt-4">
            <x-input-label for="razon_social_id" value="Razón Social *" />
            <select
                id="razon_social_id"
                name="razon_social_id"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="">Seleccione una razón social</option>
                @php
                    $razonesSociales = \App\Models\RazonSocial::all();
                @endphp
                @foreach($razonesSociales as $razon)
                    <option value="{{ $razon->id }}" {{ old('razon_social_id') == $razon->id ? 'selected' : '' }}>
                        {{ $razon->acronimo }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('razon_social_id')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="register-email" value="Email *" />
            <x-text-input
                id="register-email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="register-password" value="Contraseña *" />
            <x-text-input
                id="register-password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password" />
        </div>

        <!-- Teléfono -->
        <div class="mt-4">
            <x-input-label for="telefono" value="Teléfono" />
            <x-text-input
                id="telefono"
                class="block mt-1 w-full"
                type="text"
                name="telefono"
                :value="old('telefono')"
                maxlength="9"
                pattern="[0-9]{9}"
                placeholder="9 dígitos" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Departamento -->
        <div class="mt-4">
            <x-input-label for="departamento" value="Departamento" />
            <select
                id="departamento"
                name="departamento"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Seleccione</option>
            </select>
            <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
        </div>

        <!-- Provincia -->
        <div class="mt-4">
            <x-input-label for="provincia" value="Provincia" />
            <select
                id="provincia"
                name="provincia"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                disabled>
                <option value="">Seleccione</option>
            </select>
            <x-input-error :messages="$errors->get('provincia')" class="mt-2" />
        </div>

        <!-- Distrito -->
        <div class="mt-4">
            <x-input-label for="distrito" value="Distrito" />
            <select
                id="distrito"
                name="distrito"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                disabled>
                <option value="">Seleccione</option>
            </select>
            <x-input-error :messages="$errors->get('distrito')" class="mt-2" />
        </div>

        <!-- Dirección -->
        <div class="mt-4">
            <x-input-label for="direccion" value="Dirección" />
            <x-text-input
                id="direccion"
                class="block mt-1 w-full"
                type="text"
                name="direccion"
                :value="old('direccion')" />
            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                Registrar Empresa
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {

            /* ============================================================
               UBIGEO DINÁMICO (Departamento → Provincia → Distrito)
               ============================================================ */

            const departamentoSelect = document.getElementById("departamento");
            const provinciaSelect = document.getElementById("provincia");
            const distritoSelect = document.getElementById("distrito");

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
</x-guest-layout>
