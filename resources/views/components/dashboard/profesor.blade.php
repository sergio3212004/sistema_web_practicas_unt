@props(['profesor', 'aulas'])

<h4 class="text-xl font-bold mb-4">📚 Mis Aulas</h4>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @forelse($aulas as $aula)
        <a href="{{ route('profesor.aulas.show', $aula) }}"
           class="bg-white border rounded-lg shadow hover:shadow-lg transition p-4">

            <h5 class="text-lg font-semibold text-gray-800">
                Aula #{{ $aula->numero }}
            </h5>

            <p class="text-sm text-gray-600">
                Semestre: {{ $aula->semestre->nombre ?? '—' }}
            </p>

            <p class="text-sm text-gray-600">
                👨‍🎓 Alumnos: {{ $aula->alumnos->count() }}
            </p>

            <span class="inline-block mt-3 text-blue-600 text-sm font-semibold">
                Ver aula →
            </span>
        </a>
    @empty
        <p class="text-gray-500">No tienes aulas asignadas.</p>
    @endforelse
</div>
