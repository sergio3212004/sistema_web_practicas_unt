<section>
    <header>
        <h2 class="text-lg font-medium text-blue-700">
            Información del Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Datos de tu cuenta institucional.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- ================== ALUMNO ================== --}}
        @if(auth()->user()->alumno)
            @include('profile.partials.alumno-information')
        @endif

        {{-- ================== BOTÓN ================== --}}
       {{-- <div class="flex items-center gap-4 pt-4">
            <x-primary-button>
                Guardar cambios
            </x-primary-button>

            @if (session('status') === 'alumno-updated')
                <p class="text-sm text-green-600">
                    Teléfono actualizado correctamente.
                </p>
            @endif
        </div>--}}
    </form>
</section>
