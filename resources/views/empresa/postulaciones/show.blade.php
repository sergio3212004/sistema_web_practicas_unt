<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-blue-800">
            Postulaciones – {{ $publicacion->titulo }}
        </h2>
    </x-slot>

    <div class="bg-white shadow rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-blue-800 uppercase">Alumno</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-blue-800 uppercase">Contacto</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-blue-800 uppercase">CV</th>
                <th class="px-6 py-3 text-center text-xs font-semibold text-blue-800 uppercase">Estado</th>
                <th class="px-6 py-3 text-center text-xs font-semibold text-blue-800 uppercase">Acciones</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
            @forelse($postulaciones as $postulacion)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">
                            {{ $postulacion->alumno->user->nombre }}
                        </p>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-600">
                        <p>{{ $postulacion->alumno->telefono }}</p>
                        <p>{{ $postulacion->alumno->user->email }}</p>
                    </td>

                    <td class="px-6 py-4">
                        <a href="{{ $postulacion->alumno->cv }}"
                           target="_blank"
                           class="inline-flex items-center text-blue-700 hover:text-blue-900 font-medium">
                            @svg('heroicon-o-document-text', 'w-5 h-5 mr-1')
                            Ver CV
                        </a>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($postulacion->aprobado === true)
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Aprobado
                                </span>
                        @elseif($postulacion->aprobado === false)
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                    Rechazado
                                </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                    Pendiente
                                </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center space-x-2">
                        @if(is_null($postulacion->aprobado))
                            <form method="POST"
                                  action="{{ route('empresa.postulaciones.aprobar', $postulacion) }}"
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                    Aprobar
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('empresa.postulaciones.rechazar', $postulacion) }}"
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                    Rechazar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        No hay postulaciones registradas.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
