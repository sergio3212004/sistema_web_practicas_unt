<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animación para notificaciones */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideInRight 0.3s ease-out;
        }

        /* Patrón de fondo sutil */
        .bg-pattern {
            background-image:
                linear-gradient(to right, rgb(241 245 249 / 0.5) 1px, transparent 1px),
                linear-gradient(to bottom, rgb(241 245 249 / 0.5) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
<!-- Navegación -->
@include('layouts.navigation')

<!-- Contenedor principal con patrón de fondo -->
<div class="bg-pattern">
    <!-- Notificaciones Toast (si las hay) -->
    @if(session('success'))
        <div class="fixed top-20 right-6 z-50 animate-slide-in">
            <div class="bg-white rounded-xl shadow-lg border-l-4 border-green-500 p-4 max-w-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            ¡Éxito!
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-6 z-50 animate-slide-in">
            <div class="bg-white rounded-xl shadow-lg border-l-4 border-red-500 p-4 max-w-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            Error
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ session('error') }}
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="fixed top-20 right-6 z-50 animate-slide-in">
            <div class="bg-white rounded-xl shadow-lg border-l-4 border-yellow-500 p-4 max-w-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            Advertencia
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ session('warning') }}
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-20 right-6 z-50 animate-slide-in">
            <div class="bg-white rounded-xl shadow-lg border-l-4 border-blue-500 p-4 max-w-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            Información
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ session('info') }}
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="ml-3 flex-shrink-0 text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Scripts -->
@stack('scripts')

<!-- Auto-cerrar notificaciones después de 5 segundos -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.animate-slide-in');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        });
    });
</script>
</body>
</html>
