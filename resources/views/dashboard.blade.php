<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- 🟢 Lógica para el Rol de Administrador --}}
                    @if (isset($administrador))
                        <x-dashboard.admin :administrador="$administrador" :semestres="$semestres"/>
                    @endif
                        {{-- 🔵 Lógica para Otros Roles --}}
                    @if (isset($alumno))
                        <x-dashboard.alumno :alumno="$alumno"/>
                    @endif
                    @if (isset($profesor))
                            <x-dashboard.profesor
                                :semestre-activo="$semestreActivo"
                                :profesor="$profesor"
                                :aulas="$aulas"
                                :total-entregas="$totalEntregas"
                                :actividades-activas="$actividadesActivas"
                            />
                    @endif
                    @if (isset($empresa))
                        <x-dashboard.empresa :empresa="$empresa"/>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
