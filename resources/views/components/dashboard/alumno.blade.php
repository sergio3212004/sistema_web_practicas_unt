@props(['alumno'])

@if($alumno->aula)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('alumno.entregas.mis-entregas', $alumno->aula) }}"
           class="bg-white border rounded-lg shadow hover:shadow-lg transition p-4">

            <h5 class="text-lg font-semibold text-gray-800">
                Aula {{ $alumno->aula->numero }}
            </h5>

            <p class="text-sm text-gray-600">
                Semestre: {{ $alumno->aula->semestre->nombre ?? '—' }}
            </p>

            <p class="text-sm text-gray-600">
                👨‍🏫 Docente:
                {{ $alumno->aula->profesor->nombre_completo ?? '—' }}
            </p>

            <span class="inline-block mt-3 text-blue-600 text-sm font-semibold">
                Aula asignada
            </span>
        </a>
    </div>
@else
    <p class="text-gray-500">
        Aún no tienes un aula asignada.
    </p>
@endif
