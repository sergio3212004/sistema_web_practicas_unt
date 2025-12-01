<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">

        <h1 class="text-2xl font-bold mb-4">{{ $practica->nombre }}</h1>

        @if($practica->imagen)
            <img src="{{ asset('storage/'.$practica->imagen) }}" class="w-full h-64 object-cover rounded-lg mb-4">
        @endif

        <h2 class="text-2xl font-bold mb-4">Descripción</h2>

        <p class="text-gray-700 mb-4">{{ $practica->descripcion }}</p>

        <div class="grid grid-cols-2 gap-4 text-gray-700">
            <div>
                <strong>Fecha:</strong> {{ $practica->fecha }}
            </div>
            <div>
                <strong>Teléfono Empresa:</strong> {{ $practica->empresa->telefono ?? 'No disponible' }}
            </div>
            <div class="col-span-2">
                <strong>Email Empresa:</strong> {{ $practica->empresa->user->email ?? 'No disponible' }}
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('alumno.practicas.index') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                Volver
            </a>
        </div>

    </div>
</x-app-layout>
