<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">Prácticas Disponibles</h1>

        @if($practicas->isEmpty())
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                No hay prácticas disponibles.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($practicas as $practica)
                    <a href="{{ route('alumno.practicas.show', $practica->id) }}">
                        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition">
                            @if($practica->imagen)
                                <img src="{{ asset('storage/'.$practica->imagen) }}" class="h-40 w-full object-cover">
                            @endif
                            <div class="p-4">
                                <h2 class="text-lg font-semibold">{{ $practica->nombre }}</h2>
                                <p class="text-gray-500 text-sm mt-1">{{ $practica->fecha }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
