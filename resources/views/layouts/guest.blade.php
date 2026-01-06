@props(['title' => config('app.name'), 'subtitle' => null])

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind compilado -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            font-family: 'Figtree', system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Arial, sans-serif;
            line-height: 1.6;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>

<body class="min-h-screen relative overflow-x-hidden">
{{-- Fondo con gradiente animado --}}
<div class="fixed inset-0 -z-30 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 gradient-animate"></div>

{{-- Imagen de fondo con overlay --}}
<div class="fixed inset-0 -z-20 bg-cover bg-center opacity-10"
     style="background-image:url('{{ asset('images/bg-login.jpg') }}');"></div>

{{-- Elementos decorativos flotantes --}}
<div class="pointer-events-none fixed inset-0 overflow-hidden -z-10">
    <!-- Círculos decorativos -->
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10 float-animation" style="animation-delay: 4s;"></div>

    <!-- Marcos decorativos modernos -->
    <div class="absolute left-8 top-20 bottom-20 w-1 bg-gradient-to-b from-transparent via-yellow-400/40 to-transparent rounded-full"></div>
    <div class="absolute right-8 top-20 bottom-20 w-1 bg-gradient-to-b from-transparent via-blue-400/40 to-transparent rounded-full"></div>
</div>

{{-- Contenedor principal --}}
<main class="flex items-center justify-center min-h-screen px-4 py-12 relative">
    <div class="w-full max-w-md">
        {{-- Tarjeta principal --}}
        <div class="relative">
            <!-- Efecto de brillo detrás de la tarjeta -->
            <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 via-blue-500 to-indigo-600 rounded-2xl blur opacity-25"></div>

            <!-- Tarjeta contenido -->
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- Header con gradiente --}}
                <div class="bg-gradient-to-br from-blue-800 to-blue-900 px-8 py-10 text-center relative overflow-hidden">
                    <!-- Patrón decorativo -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white rounded-full -mr-20 -mt-20"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white rounded-full -ml-16 -mb-16"></div>
                    </div>

                    <!-- Logo y título -->
                    <div class="relative space-y-4">
                        <div class="flex justify-center">
                            <div class="bg-white rounded-2xl p-4 shadow-lg">
                                <img src="{{ asset('logo-informatica.png') }}"
                                     alt="Logo UNT"
                                     class="h-20 w-auto object-contain">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h1 class="text-3xl font-bold text-white tracking-tight">
                                <span class="block">PRÁCTICAS</span>
                                <span class="block text-yellow-400">Pre Profesionales</span>
                            </h1>

                            @if ($subtitle)
                                <p class="text-blue-100 text-sm font-medium">{{ $subtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tabs de navegación --}}
                <div class="bg-gray-50 border-b border-gray-200">
                    <div class="flex">
                        <a href="{{ route('login') }}"
                           class="flex-1 px-6 py-4 text-center text-sm font-semibold transition-all duration-200 relative
                                      {{ request()->routeIs('login')
                                         ? 'text-blue-700 bg-white'
                                         : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Iniciar Sesión</span>
                                </span>
                            @if(request()->routeIs('login'))
                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                            @endif
                        </a>

                        <a href="{{ route('empresa.register.form') }}"
                           class="flex-1 px-6 py-4 text-center text-sm font-semibold transition-all duration-200 relative
                                      {{ request()->routeIs('empresa.*')
                                         ? 'text-blue-700 bg-white'
                                         : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>Registro Empresa</span>
                                </span>
                            @if(request()->routeIs('empresa.*'))
                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- Contenido dinámico (formulario) --}}
                <div class="px-8 py-8">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 border-t border-gray-200 px-8 py-4">
                    <p class="text-center text-xs text-gray-600">
                        © {{ date('Y') }} Universidad Nacional de Trujillo
                        <span class="mx-2">•</span>
                        <span class="text-gray-500">Escuela de Ingeniería Informática</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
