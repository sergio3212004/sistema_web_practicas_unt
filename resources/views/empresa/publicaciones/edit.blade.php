<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">

        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <x-heroicon-o-pencil-square class="h-7 w-7 text-indigo-600"/>
            Editar Publicación
        </h1>

        <!-- MENSAJES DE ERROR -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('empresa.publicaciones.update', $publicacion->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Título</label>
                <input type="text" name="nombre"
                       class="w-full mt-1 rounded-lg border-gray-300"
                       value="{{ old('nombre', $publicacion->nombre) }}" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" rows="5"
                          class="w-full mt-1 rounded-lg border-gray-300"
                          required>{{ old('descripcion', $publicacion->descripcion) }}</textarea>
            </div>

            <!-- Fecha -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha"
                       class="w-full mt-1 rounded-lg border-gray-300"
                       value="{{ old('fecha', $publicacion->fecha) }}" required>
            </div>

            <!-- Imagen actual -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Imagen actual</label>

                @if($publicacion->imagen && Storage::disk('public')->exists($publicacion->imagen))
                    <img src="{{ asset('storage/' . $publicacion->imagen) }}"
                         class="h-40 rounded shadow mt-2">
                @else
                    <p class="text-gray-500 mt-1">No hay imagen.</p>
                @endif
            </div>

            <!-- Cambiar imagen -->
            <div class="mb-6">
                <label class="block font-medium text-gray-700">Subir nueva imagen</label>
                <input type="file" name="imagen"
                       class="mt-2"
                       accept="image/*">
                <p class="text-sm text-gray-500">Déjalo vacío si no deseas cambiar la imagen.</p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('empresa.publicaciones.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                    Actualizar
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
