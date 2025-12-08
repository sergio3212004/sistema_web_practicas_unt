<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl">

        <!-- Título y botón -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                <x-heroicon-o-academic-cap class="h-8 w-8 text-indigo-600"/>
                Listado de Aulas
            </h1>

            <a href="{{ route('admin.aulas.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                + Nueva Aula
            </a>
        </div>

        <!-- Si no hay aulas -->
        @if($aulas->isEmpty())
            <div class="bg-gray-100 text-gray-600 p-6 rounded-lg text-center border">
                No hay aulas registradas.
            </div>
        @else

            <!-- Tabla -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Número</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Semestre</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Profesor</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Acciones</th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">

                    @foreach ($aulas as $aula)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- Número -->
                            <td class="px-4 py-3 text-sm text-gray-800">
                                {{ $aula->numero }}
                            </td>

                            <!-- Semestre -->
                            <td class="px-4 py-3 text-sm text-gray-800">
                                {{ $aula->semestre->nombre ?? 'No asignado' }}
                            </td>

                            <!-- Profesor -->
                            <td class="px-4 py-3 text-sm text-gray-800">
                                @if ($aula->profesor)
                                    {{ $aula->profesor->nombres }} ({{ $aula->profesor->codigo_profesor }})
                                @else
                                    Sin profesor
                                @endif
                            </td>


                            <!-- Acciones -->
                            <td class="px-4 py-3 text-sm text-center">
                                <div class="flex justify-center gap-2">

                                    <!-- Ver / Mostrar -->
                                    <a href="{{ route('admin.aulas.show', $aula) }}"
                                       class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 text-sm">
                                        Ver
                                    </a>

                                    <!-- Editar -->
                                    <a href="{{ route('admin.aulas.edit', $aula) }}"
                                       class="px-3 py-1 text-white bg-yellow-600 rounded hover:bg-yellow-700 text-sm">
                                        Editar
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('admin.aulas.destroy', $aula) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este aula?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        @endif

        <!-- Paginación -->
        <div class="mt-6">
            {{ $aulas->links() }}
        </div>

    </div>
</x-app-layout>
