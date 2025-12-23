<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Fichas de Registro
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-6">
                <a href="{{ route('alumno.ficha.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    + Nueva Ficha
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">
                            Ciclo
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">
                            Empresa
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">
                            Periodo
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">
                            Estado
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                    @forelse($fichas as $ficha)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $ficha->ciclo }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $ficha->razon_social }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $ficha->fecha_inicio?->format('d/m/Y') }}
                                -
                                {{ $ficha->fecha_termino?->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($ficha->aceptado)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                            Aceptado
                                        </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                            En revisión
                                        </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                Aún no tienes fichas registradas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
