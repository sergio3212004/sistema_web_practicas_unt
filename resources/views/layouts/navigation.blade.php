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
        class="w-64 bg-gray-900 text-gray-200 flex flex-col fixed h-full z-30">

        <!-- Espacio para la barra superior -->
        <div class="h-16"></div>

        <!-- Logo -->
        <div class="flex justify-center py-6">
            <img src="{{ asset('logo-informatica.png') }}"
                 class="w-32 rounded-md"
                 alt="Logo">
        </div>

        <!-- Navegación del menú -->
        <nav class="space-y-1 flex-1 px-3 py-2 overflow-y-auto">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center">
                @svg('heroicon-o-home', 'w-6 h-6 flex-shrink-0')
                <span class="ml-3">Dashboard</span>
            </x-responsive-nav-link>

            @php
                $rol = Auth::user()->rol->nombre;

                $menus = [
                    'administrador' => [
                        [
                            'route' => 'admin.usuarios.index',
                            'name' => 'Usuarios',
                            'icon' => 'heroicon-o-users'
                        ],
                    ],
                ];
            @endphp

            @if(isset($menus[$rol]))
                @foreach($menus[$rol] as $item)
                    <x-responsive-nav-link
                        :href="route($item['route'])"
                        :active="request()->routeIs($item['route'])"
                        class="flex items-center">

                        @svg($item['icon'], 'w-6 h-6 flex-shrink-0')
                        <span class="ml-3">{{ $item['name'] }}</span>
                    </x-responsive-nav-link>
                @endforeach
            @endif


        </nav>

        <!-- Opciones de usuario (perfil y logout) -->
        <div class="border-t border-gray-700 p-3 space-y-1">

            <!-- Perfil -->
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center">
                @svg('heroicon-o-user-circle', 'w-6 h-6 flex-shrink-0')
                <span class="ml-3">Perfil</span>
            </x-responsive-nav-link>

            <!-- Cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-3 py-2 rounded-md text-left text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    @svg('heroicon-o-arrow-left-on-rectangle', 'w-6 h-6 flex-shrink-0')
                    <span class="ml-3">Cerrar sesión</span>
                </button>
            </form>

        </div>


    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-col" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

        <!-- Barra superior con botón toggle -->
        <header class="bg-white border-b border-gray-100 shadow-sm h-16 flex items-center px-4 fixed top-0 right-0 left-0 z-20"
                :class="sidebarOpen ? 'ml-64' : 'ml-0'">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                @svg('heroicon-o-bars-3', 'w-6 h-6')
            </button>

            <!-- Aquí puedes agregar más elementos en el header si lo necesitas -->
            <div class="flex-1"></div>
        </header>

        <!-- Contenido de la página -->
        <main class="flex-1 mt-16 overflow-y-auto">
            <!-- Page Heading -->
            @isset($header)
                <div class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <!-- Page Content -->
            <div>
                {{ $slot }}
            </div>
        </main>

    </div>

</div>
