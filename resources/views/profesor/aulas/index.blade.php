<x-app-layout>
    <div class="container mx-auto px-4">

        <h3 class="text-2xl font-bold mb-6">
            📚 Aulas del profesor {{ $profesor->nombres }} {{ $profesor->apellido_paterno }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($aulas as $aula)
                <a href="{{ route('profesor.aulas.show', $aula) }}"
                   class="bg-white border rounded-lg shadow hover:shadow-lg transition p-5">

                    <h4 class="text-lg font-semibold text-gray-800 mb-2">
                        Aula #{{ $aula->numero }}
                    </h4>

                    <p class="text-sm text-gray-600">
                        📆 Semestre:
                        <span class="font-medium">
                        {{ $aula->semestre->nombre ?? 'No asignado' }}
                    </span>
                    </p>

                    <p class="text-sm text-gray-600 mt-1">
                        👨‍🎓 Alumnos:
                        <span class="font-medium">
                        {{ $aula->alumnos->count() }}
                    </span>
                    </p>

                    <div class="mt-4">
                    <span class="inline-block text-blue-600 font-semibold text-sm">
                        Ver aula →
                    </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded">
                    No tienes aulas asignadas actualmente.
                </div>
            @endforelse

        </div>

    </div>
</x-app-layout>
