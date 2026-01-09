<div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-50">

    <!-- Sidebar -->
    <aside
        x-show="sidebarOpen"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="w-72 bg-white border-r border-gray-200 flex flex-col fixed h-full z-30 shadow-lg">

        <!-- Logo y Header -->
        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-8">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('logo-informatica.png') }}"
                     class="w-36 rounded-lg shadow-md bg-white p-2"
                     alt="Logo">
            </div>
            <div class="text-center">
                <h3 class="text-white font-semibold text-sm tracking-wide">PRÁCTICAS PRE PROFESIONALES</h3>
                <p class="text-blue-200 text-xs mt-1">Universidad Nacional de Trujillo</p>
                <p class="text-blue-200 text-xs mt-1">Escuela de Informática</p>
            </div>
        </div>

        <!-- Navegación del menú -->
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <div class="space-y-2">
                <x-responsive-nav-link
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')"
                    class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group hover:bg-blue-50">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                        @svg('heroicon-o-home', 'w-5 h-5 text-blue-700')
                    </div>
                    <span class="ml-4 font-medium text-gray-700 group-hover:text-blue-800">Dashboard</span>
                </x-responsive-nav-link>

                @php
                    $rol = auth()->user()->rol->nombre;

                    $menus = [
                        'administrador' => [
                            [
                                'route' => 'admin.usuarios.index',
                                'name' => 'Usuarios',
                                'icon' => 'heroicon-o-users',
                                'color' => 'purple'
                            ],
                            [
                                'route' => 'admin.aulas.index',
                                'name' => 'Aulas',
                                'icon' => 'heroicon-o-academic-cap',
                                'color' => 'indigo'
                            ],
                            [
                                'route' => 'admin.aprobaciones.index',
                                'name' => 'Aprobaciones',
                                'icon' => 'heroicon-o-check-circle',
                                'color' => 'green'
                            ],
                            [
                                'route' => 'admin.informes-finales.index',
                                'name' => 'Informes Finales',
                                'icon' => 'heroicon-o-document-chart-bar',
                                'color' => 'orange'
                            ]
                        ],
                        'alumno' => [
                            [
                                'route' => 'alumno.practicas.index',
                                'name' => 'Prácticas Disponibles',
                                'icon' => 'heroicon-o-newspaper',
                                'color' => 'blue'
                            ],
                            [
                                'route' => 'alumno.ficha.index',
                                'name' => 'Ficha de registro',
                                'icon' => 'heroicon-o-document',
                                'color' => 'cyan'
                            ],
                            [
                                'route' => 'alumno.informe-final.index',
                                'name' => 'Informe Final',
                                'icon' => 'heroicon-o-document-arrow-up',
                                'color' => 'teal'
                            ]
                        ],
                        'profesor' => [
/*                            [
                                'route' => 'profesor.entregas.index',
                                'name' => 'Informes',
                                'icon' => 'heroicon-o-document-text',
                                'color' => 'blue'
                            ],
                            [
                                'route' => 'profesor.entregas.create',
                                'name' => 'Crear Entregas',
                                'icon' => 'heroicon-o-document-plus',
                                'color' => 'green'
                            ],*/
                            [
                                'route' => 'profesor.informes-finales.index',
                                'name' => 'Informes Finales',
                                'icon' => 'heroicon-o-document-chart-bar',
                                'color' => 'orange'
                            ],
                            [
                                'route' => 'profesor.formato-once.index',
                                'name' => 'Formato 11 - PPP',
                                'icon' => 'heroicon-o-clipboard-document-check',
                                'color' => 'green'
                            ]
                        ],
                        'empresa' => [
                            [
                                'route' => 'empresa.publicaciones.index',
                                'name' => 'Publicaciones',
                                'icon' => 'heroicon-o-newspaper',
                                'color' => 'indigo'
                            ],
                            [
                                'route' => 'empresa.postulaciones.index',
                                'name' => 'Postulaciones',
                                'icon' => 'heroicon-o-paper-airplane',
                                'color' => 'blue'
                            ]
                        ]
                    ];
                @endphp

                @if(isset($menus[$rol]))
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Menú Principal</p>
                        @foreach($menus[$rol] as $item)
                            @php
                                $colorClasses = [
                                    'blue' => ['bg' => 'bg-blue-100', 'hover' => 'group-hover:bg-blue-200', 'text' => 'text-blue-700'],
                                    'purple' => ['bg' => 'bg-purple-100', 'hover' => 'group-hover:bg-purple-200', 'text' => 'text-purple-700'],
                                    'indigo' => ['bg' => 'bg-indigo-100', 'hover' => 'group-hover:bg-indigo-200', 'text' => 'text-indigo-700'],
                                    'green' => ['bg' => 'bg-green-100', 'hover' => 'group-hover:bg-green-200', 'text' => 'text-green-700'],
                                    'orange' => ['bg' => 'bg-orange-100', 'hover' => 'group-hover:bg-orange-200', 'text' => 'text-orange-700'],
                                    'cyan' => ['bg' => 'bg-cyan-100', 'hover' => 'group-hover:bg-cyan-200', 'text' => 'text-cyan-700'],
                                    'teal' => ['bg' => 'bg-teal-100', 'hover' => 'group-hover:bg-teal-200', 'text' => 'text-teal-700'],
                                ];
                                $colors = $colorClasses[$item['color']] ?? $colorClasses['blue'];
                            @endphp
                            <x-responsive-nav-link
                                :href="route($item['route'])"
                                :active="request()->routeIs($item['route'])"
                                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group hover:bg-blue-50 mb-1">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $colors['bg'] }} {{ $colors['hover'] }} transition-colors">
                                    @svg($item['icon'], 'w-5 h-5 ' . $colors['text'])
                                </div>
                                <span class="ml-4 font-medium text-gray-700 group-hover:text-blue-800">{{ $item['name'] }}</span>
                            </x-responsive-nav-link>
                        @endforeach
                    </div>
                @endif
            </div>
        </nav>

        <!-- Opciones de usuario -->
        <div class="border-t border-gray-200 bg-gray-50 px-4 py-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Cuenta</p>

            <!-- Perfil -->
            <x-responsive-nav-link
                :href="route('profile.edit')"
                :active="request()->routeIs('profile.edit')"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group hover:bg-blue-50 mb-2">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-200 group-hover:bg-blue-200 transition-colors">
                    @svg('heroicon-o-user-circle', 'w-5 h-5 text-gray-700')
                </div>
                <span class="ml-4 font-medium text-gray-700 group-hover:text-blue-800">Perfil</span>
            </x-responsive-nav-link>

            <!-- Cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-4 py-3 rounded-lg transition-all duration-200 group hover:bg-red-50">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-100 group-hover:bg-red-200 transition-colors">
                        @svg('heroicon-o-arrow-left-on-rectangle', 'w-5 h-5 text-red-700')
                    </div>
                    <span class="ml-4 font-medium text-gray-700 group-hover:text-red-800">Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-col" :class="sidebarOpen ? 'ml-72' : 'ml-0'">

        <!-- Barra superior -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center px-6 fixed top-0 right-0 left-0 z-20 shadow-sm"
                :class="sidebarOpen ? 'ml-72' : 'ml-0'">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg text-gray-500 hover:text-blue-800 hover:bg-blue-50 transition-all duration-200">
                @svg('heroicon-o-bars-3', 'w-6 h-6')
            </button>

            <!-- Indicador de ubicación -->
            <div class="ml-6 hidden md:block">
                <div class="flex items-center text-sm text-gray-600">
                    @svg('heroicon-o-home', 'w-4 h-4 mr-2')
                    <span class="font-medium text-blue-800">{{ ucfirst(auth()->user()->rol->nombre) ?? 'Usuario' }}</span>
                </div>
            </div>

            <div class="flex-1"></div>

            <!-- Info del usuario -->
            <div class="flex items-center space-x-3">
                <div class="hidden md:block text-right">
                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->nombre ?? 'Usuario' }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Contenido de la página -->
        <main class="flex-1 mt-16 overflow-y-auto bg-gray-50">
            @isset($header)
                <div class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <div class="p-6">
                {{ $slot }}
            </div>
        </main>

    </div>

</div>
