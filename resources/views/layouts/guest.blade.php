@props(['title' => config('app.name'), 'subtitle' => null])

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind compilado -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        html, body {
            font-family: 'Montserrat', system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Arial, sans-serif;
            line-height: 1.9;
        }
    </style>
</head>

<body class="min-h-screen text-slate-900 relative">
{{-- Fondo institucional difuminado --}}
<div class="fixed inset-0 -z-20 bg-cover bg-center"
     style="background-image:url('{{ asset('images/bg-login.jpg') }}');"></div>

{{-- Capa blanca translúcida con blur --}}
<div class="fixed inset-0 -z-10 bg-white/25 backdrop-blur-md"></div>

{{-- Marcos decorativos suaves --}}
<div class="pointer-events-none fixed inset-0">
    <div class="absolute left-10 top-16 bottom-16 w-px bg-indigo-900/60 rounded"></div>
    <div class="absolute right-10 top-16 bottom-16 w-px bg-yellow-400/60 rounded"></div>

    <div class="absolute top-16 left-10 h-px w-48 bg-indigo-900/60 rounded"></div>
    <div class="absolute top-16 right-10 h-px w-48 bg-yellow-400/60 rounded"></div>
    <div class="absolute bottom-16 left-10 h-px w-48 bg-indigo-900/60 rounded"></div>
    <div class="absolute bottom-16 right-10 h-px w-48 bg-yellow-400/60 rounded"></div>
</div>

{{-- Contenedor principal --}}
<main class="flex items-center justify-center min-h-screen px-4 py-8">
    <div class="w-full max-w-lg">
        {{-- Tarjeta con bordes más cuadrados y margen superior ajustado --}}
        <div class="bg-white/95 border border-slate-300 rounded-lg shadow-2xl px-12 py-6 text-center space-y-8 mt-[-2rem]">

            {{-- Logo grande --}}
            <div class="flex flex-col items-center space-y-4">
                <img src="{{ asset('logo-informatica.png') }}" alt="Logo UNT" class="h-24 w-auto object-contain">

                {{-- Título en dos líneas --}}
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-wide leading-relaxed">
                    <span class="block uppercase tracking-wider">PRACTICAS</span>
                    <span class="block">Pre-Profesionales</span>
                </h1>

                {{-- Subtítulo dinámico --}}
                @if ($subtitle)
                    <p class="text-slate-600 text-base">{{ $subtitle }}</p>
                @endif
            </div>

            <div class="flex justify-center gap-4 mb-6">
                <a href="{{ route('login') }}"
                   class="px-6 py-2 text-sm font-semibold rounded-lg
              {{ request()->routeIs('login') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Login
                </a>

                <a href="{{ route('empresa.register.form') }}"
                   class="px-6 py-2 text-sm font-semibold rounded-lg
              {{ request()->routeIs('empresa.*') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Registro Empresa
                </a>
            </div>

            {{-- Contenido dinámico (formulario, etc.) --}}
            <div class="mt-6 text-left">
                {{ $slot }}
            </div>

            {{-- Línea inferior --}}
            <div class="border-t border-slate-200 pt-3 mt-3">
                <p class="text-xs text-slate-600">
                    © {{ date('Y') }} {{ config('app.name') }} — Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</main>
</body>
</html>
