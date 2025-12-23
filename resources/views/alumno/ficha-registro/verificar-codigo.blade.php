<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verificación de Seguridad
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6">

            <p class="text-sm text-gray-600 mb-4">
                Te enviamos un código de 6 dígitos a tu correo electrónico.
            </p>

            @if(session('info'))
                <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded">
                    {{ session('info') }}
                </div>
            @endif

            <form method="POST" action="{{ route('alumno.ficha.codigo.verificar') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Código de verificación
                    </label>
                    <input
                        type="text"
                        name="codigo"
                        maxlength="6"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                    @error('codigo')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                >
                    Verificar código
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
