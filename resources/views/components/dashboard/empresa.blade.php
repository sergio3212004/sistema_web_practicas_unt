@props(['empresa'])
<div class="space-y-6">
    {{-- Header de Bienvenida --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-2">Bienvenido, {{ $empresa->nombre }} {{ $empresa->razonSocial->acronimo }}</h3>
                <p class="text-blue-100 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">{{ $empresa->razonSocial->nombre ?? 'Empresa' }}</span>
                    <span class="text-blue-200">|</span>
                    <span>RUC: {{ $empresa->ruc }}</span>
                </p>
            </div>

        </div>
    </div>

    {{-- Tarjetas de Estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total de Publicaciones --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total de Ofertas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $empresa->publicacion->count() }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Publicaciones Activas --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ofertas Activas</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ $empresa->publicacion->where('estado', 'Disponible')->count() }}
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total de Postulaciones --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Postulaciones</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ $empresa->publicacion->sum(function($pub) { return $pub->postulaciones->count(); }) }}
                    </p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Postulaciones Pendientes --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pendientes de Revisión</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ $empresa->publicacion->sum(function($pub) {
                            return $pub->postulaciones->where('estado', 'pendiente')->count();
                        }) }}
                    </p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Información de la Empresa y Acciones Rápidas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Información de la Empresa --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Información de la Empresa
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Razón Social</p>
                        <p class="text-gray-900">{{ $empresa->razonSocial->acronimo ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Teléfono</p>
                        <p class="text-gray-900">{{ $empresa->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Email</p>
                        <p class="text-gray-900">{{ $empresa->user->email }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Ubicación</p>
                        <p class="text-gray-900">
                            {{ $empresa->distrito }}, {{ $empresa->provincia }}<br>
                            {{ $empresa->departamento }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Dirección</p>
                        <p class="text-gray-900">{{ $empresa->direccion ?? 'No especificada' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
