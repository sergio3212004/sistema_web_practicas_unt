<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-6 rounded-t-xl">
                <h4 class="text-2xl font-bold text-gray-800">Gestión de Formatos de Calidad</h4>
                <p class="text-sm text-gray-600 mt-1">Filtra los formatos 11 y 12 por semestre, profesor o aula</p>
            </div>

            <div class="p-6">
                <!-- Filtros -->
                <form method="GET" action="{{ route('admin.formatos.index') }}" class="mb-6" id="formFiltros">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Tipo de Formato -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Formato</label>
                            <select name="tipo_formato"
                                    id="tipo_formato"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="all" {{ $tipoFormato === 'all' ? 'selected' : '' }}>Todos los formatos</option>
                                <option value="11" {{ $tipoFormato === '11' ? 'selected' : '' }}>Solo Formato 11</option>
                                <option value="12" {{ $tipoFormato === '12' ? 'selected' : '' }}>Solo Formato 12</option>
                            </select>
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Semestre</label>
                            <select name="semestre_id"
                                    id="semestre_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="">Todos los semestres</option>
                                @foreach($semestres as $semestre)
                                    <option value="{{ $semestre->id }}" {{ $semestreId == $semestre->id ? 'selected' : '' }}>
                                        {{ $semestre->nombre }} {{ $semestre->activo ? '(Activo)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Búsqueda Profesor -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Profesor</label>
                            <input type="text"
                                   name="busqueda_profesor"
                                   id="busqueda_profesor"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                   placeholder="Código o nombre..."
                                   value="{{ $busquedaProfesor }}">
                            <p class="text-xs text-gray-500 mt-1">Busca por código o nombre del profesor</p>
                        </div>

                        <!-- Aula -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Aula</label>
                            <select name="aula_id"
                                    id="aula_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="">Todas las aulas</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ $aulaId == $aula->id ? 'selected' : '' }}>
                                        Aula {{ $aula->numero }} - {{ $aula->semestre->nombre }} - {{ $aula->profesor->apellido_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center gap-2 mt-4">
                        <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium px-6 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow flex items-center">
                            @svg('heroicon-o-magnifying-glass', 'w-5 h-5 mr-2')
                            Filtrar
                        </button>
                        <a href="{{ route('admin.formatos.index') }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition-all duration-200 flex items-center">
                            @svg('heroicon-o-x-mark', 'w-5 h-5 mr-2')
                            Limpiar filtros
                        </a>

                        <!-- Indicadores de filtros activos -->
                        @if($semestreId || $busquedaProfesor || $aulaId || $tipoFormato !== 'all')
                            <div class="ml-auto flex items-center gap-2">
                                <span class="text-sm text-gray-600">Filtros activos:</span>
                                @if($tipoFormato !== 'all')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Formato {{ $tipoFormato }}
                                    </span>
                                @endif
                                @if($semestreId)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Semestre
                                    </span>
                                @endif
                                @if($busquedaProfesor)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Profesor: {{ $busquedaProfesor }}
                                    </span>
                                @endif
                                @if($aulaId)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        Aula específica
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </form>

                <!-- Divisor -->
                <div class="border-t border-gray-200 my-6"></div>

                <!-- Resultados -->
                <div class="space-y-8">
                    <!-- Resultados Formato 11 -->
                    @if($formatosOnce && $formatosOnce->count() > 0)
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-100 text-blue-800 font-semibold text-sm">
                                        @svg('heroicon-o-clipboard-document-check', 'w-5 h-5 mr-2')
                                        Formato 11
                                    </span>
                                    <span class="ml-3 text-sm text-gray-600">{{ $formatosOnce->total() }} registros encontrados</span>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aula</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Semestre</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Profesor</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alumnos</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($formatosOnce as $formato)
                                            <tr class="hover:bg-blue-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $formato->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                            Aula {{ $formato->aula->numero }}
                                                        </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $formato->aula->semestre->nombre }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                    <div>
                                                        {{ $formato->aula->profesor->apellido_paterno }} {{ $formato->aula->profesor->apellido_materno }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">Código: {{ $formato->aula->profesor->codigo_profesor }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <button type="button"
                                                            onclick="openModal('alumnos11-{{ $formato->id }}')"
                                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm underline decoration-dotted">
                                                        {{ $formato->formatoOnceAlumnos->count() }} alumnos
                                                    </button>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($formato->firma_coordinador)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                                                Firmado
                                                            </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                @svg('heroicon-o-clock', 'w-4 h-4 mr-1')
                                                                Pendiente
                                                            </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('admin.formatos.once.show', $formato->id) }}"
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                                            @svg('heroicon-o-eye', 'w-4 h-4 mr-1')
                                                            Ver
                                                        </a>
                                                        <a href="{{ route('admin.formatos.once.pdf', $formato->id) }}"
                                                           class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                                                            @svg('heroicon-o-arrow-down-tray', 'w-4 h-4 mr-1')
                                                            PDF
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4">
                                {{ $formatosOnce->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif

                    <!-- Resultados Formato 12 -->
                    @if($formatosDoce && $formatosDoce->count() > 0)
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-lg bg-green-100 text-green-800 font-semibold text-sm">
                                        @svg('heroicon-o-clipboard-document-check', 'w-5 h-5 mr-2')
                                        Formato 12
                                    </span>
                                    <span class="ml-3 text-sm text-gray-600">{{ $formatosDoce->total() }} registros encontrados</span>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aula</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Semestre</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Profesor</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nivel</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alumnos</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($formatosDoce as $formato)
                                            <tr class="hover:bg-green-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $formato->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                            Aula {{ $formato->aula->numero }}
                                                        </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $formato->aula->semestre->nombre }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                    <div>
                                                        {{ $formato->aula->profesor->apellido_paterno }} {{ $formato->aula->profesor->apellido_materno }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">Código: {{ $formato->aula->profesor->codigo_profesor }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            {{ ucfirst($formato->nivel) }}
                                                        </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <button type="button"
                                                            onclick="openModal('alumnos12-{{ $formato->id }}')"
                                                            class="text-green-600 hover:text-green-800 font-medium text-sm underline decoration-dotted">
                                                        {{ $formato->formatosDoceAlumnos->count() }} alumnos
                                                    </button>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($formato->firma_coordinador)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                                                Firmado
                                                            </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                @svg('heroicon-o-clock', 'w-4 h-4 mr-1')
                                                                Pendiente
                                                            </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('admin.formatos.doce.show', $formato->id) }}"
                                                           class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors">
                                                            @svg('heroicon-o-eye', 'w-4 h-4 mr-1')
                                                            Ver
                                                        </a>
                                                        <a href="{{ route('admin.formatos.doce.pdf', $formato->id) }}"
                                                           class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                                                            @svg('heroicon-o-arrow-down-tray', 'w-4 h-4 mr-1')
                                                            PDF
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4">
                                {{ $formatosDoce->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif

                    <!-- Sin resultados -->
                    @if(($formatosOnce === null || $formatosOnce->count() === 0) && ($formatosDoce === null || $formatosDoce->count() === 0))
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                            @svg('heroicon-o-information-circle', 'w-16 h-16 mx-auto text-blue-600 mb-4')
                            <p class="text-gray-700 font-medium">No se encontraron formatos con los criterios de búsqueda seleccionados.</p>
                            <p class="text-sm text-gray-600 mt-2">Intenta ajustar los filtros para obtener resultados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para Formato 11 -->
    @if($formatosOnce)
        @foreach($formatosOnce as $formato)
            <div id="alumnos11-{{ $formato->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-lg bg-white">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Alumnos - Formato 11 #{{ $formato->id }}</h3>
                        <button onclick="closeModal('alumnos11-{{ $formato->id }}')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            @svg('heroicon-o-x-mark', 'w-6 h-6')
                        </button>
                    </div>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Código</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Alumno</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Sede Prácticas</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Conformidad</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($formato->formatoOnceAlumnos as $fa)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $fa->alumno->codigo_matricula }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $fa->alumno->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $fa->sede_practicas ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $fa->conformidad ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button onclick="closeModal('alumnos11-{{ $formato->id }}')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Modales para Formato 12 -->
    @if($formatosDoce)
        @foreach($formatosDoce as $formato)
            <div id="alumnos12-{{ $formato->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-lg bg-white">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Alumnos - Formato 12 #{{ $formato->id }}</h3>
                        <button onclick="closeModal('alumnos12-{{ $formato->id }}')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            @svg('heroicon-o-x-mark', 'w-6 h-6')
                        </button>
                    </div>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Código</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Alumno</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Sede Práctica</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Responsable</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Al Día</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($formato->formatosDoceAlumnos as $fa)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $fa->alumno->codigo_matricula }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $fa->alumno->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $fa->sede_practica ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $fa->responsable ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($fa->al_dia)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Sí</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">No</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button onclick="closeModal('alumnos12-{{ $formato->id }}')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-opacity-50')) {
                event.target.classList.add('hidden');
            }
        }

        // Auto-submit cuando cambia el semestre para actualizar aulas
        document.getElementById('semestre_id').addEventListener('change', function() {
            document.getElementById('formFiltros').submit();
        });
    </script>
</x-app-layout>
