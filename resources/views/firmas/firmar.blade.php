<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Firma de Ficha de Registro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-8">

    <!-- ENCABEZADO -->
    <div class="text-center border-b pb-6 mb-6">
        <h1 class="text-xl font-bold text-gray-800">
            FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS
        </h1>
        <h2 class="text-lg font-semibold text-gray-700">
            PROGRAMA DE INFORMÁTICA
        </h2>
        <p class="text-sm text-gray-500 mt-2">
            FICHA DE REGISTRO DE PRÁCTICAS PRE PROFESIONALES
        </p>

        <span class="inline-block mt-3 px-4 py-1 rounded-full text-sm
            {{ $firmaToken->tipo === 'empresa'
                ? 'bg-blue-100 text-blue-700'
                : 'bg-green-100 text-green-700' }}">
            {{ $firmaToken->tipo === 'empresa'
                ? 'V°B° EMPRESA'
                : 'V°B° PROGRAMA' }}
        </span>
    </div>

    <!-- DATOS DEL ESTUDIANTE -->
    <section class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-2">1. Datos del Estudiante</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><strong>Alumno:</strong> {{ $firmaToken->ficha->alumno->nombre_completo }}</p>
            <p><strong>Matrícula:</strong> {{ $firmaToken->ficha->alumno->codigo_matricula }}</p>
            <p><strong>Ciclo:</strong> {{ $firmaToken->ficha->ciclo }}</p>
            <p><strong>Semestre:</strong> {{ $firmaToken->ficha->semestre->nombre }}</p>
            <p><strong>Correo:</strong> {{ $firmaToken->ficha->alumno->user->email }}</p>
        </div>
    </section>

    <!-- DATOS DE LA EMPRESA -->
    <section class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-2">2. Empresa o Institución</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><strong>Razón Social:</strong> {{ $firmaToken->ficha->razon_social }}</p>
            <p><strong>RUC:</strong> {{ $firmaToken->ficha->ruc }}</p>
            <p><strong>Correo Empresa:</strong> {{ $firmaToken->ficha->correo_empresa }}</p>
            <p><strong>Gerente:</strong> {{ $firmaToken->ficha->nombre_gerente }}</p>
            <p><strong>Jefe RRHH:</strong> {{ $firmaToken->ficha->nombre_jefe_rrhh }}</p>
            <p class="col-span-2"><strong>Dirección:</strong> {{ $firmaToken->ficha->direccion }}</p>
            <p><strong>Tel. Fijo:</strong> {{ $firmaToken->ficha->telefono_fijo }}</p>
            <p><strong>Tel. Móvil:</strong> {{ $firmaToken->ficha->telefono_movil }}</p>
            <p><strong>Ubicación:</strong>
                {{ $firmaToken->ficha->departamento }},
                {{ $firmaToken->ficha->provincia }},
                {{ $firmaToken->ficha->distrito }}
            </p>
        </div>
    </section>

    <!-- DATOS DE LA PRÁCTICA -->
    <section class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-2">3. Características de la Práctica</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><strong>Fecha Inicio:</strong> {{ $firmaToken->ficha->fecha_inicio->format('d/m/Y') }}</p>
            <p><strong>Fecha Término:</strong> {{ $firmaToken->ficha->fecha_termino->format('d/m/Y') }}</p>
            <p><strong>Área:</strong> {{ $firmaToken->ficha->area_practicas }}</p>
            <p><strong>Cargo:</strong> {{ $firmaToken->ficha->cargo }}</p>
            <p><strong>Jefe Directo:</strong> {{ $firmaToken->ficha->nombre_jefe_directo }}</p>
            <p><strong>Correo Jefe:</strong> {{ $firmaToken->ficha->correo_jefe_directo }}</p>
        </div>

        <div class="mt-3 text-sm">
            <strong>Descripción:</strong>
            <p class="mt-1 text-gray-700">
                {{ $firmaToken->ficha->descripcion }}
            </p>
        </div>
    </section>

    <!-- HORARIOS -->
    <section class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-2">4. Horarios</h3>

        <table class="w-full text-sm border border-gray-300">
            <thead class="bg-gray-50">
            <tr>
                <th class="border px-2 py-1">Día</th>
                <th class="border px-2 py-1">Hora Inicio</th>
                <th class="border px-2 py-1">Hora Fin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($firmaToken->ficha->horarios as $horario)
                <tr>
                    <td class="border px-2 py-1">{{ $horario->nombre_dia }}</td>
                    <td class="border px-2 py-1">{{ $horario->hora_inicio }}</td>
                    <td class="border px-2 py-1">{{ $horario->hora_fin }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <!-- FIRMA -->
    <section class="border-t pt-6">
        <h3 class="font-semibold text-gray-800 mb-3 text-center">
            Firma Digital
        </h3>

        <form method="POST" class="max-w-md mx-auto">
            @csrf

            <canvas id="canvasFirma"
                    class="border-2 border-dashed border-gray-400 rounded mx-auto block bg-gray-50"
                    width="360"
                    height="140"></canvas>

            <input type="hidden" name="firma" id="firma">

            <div class="text-center mt-3">
                <button type="button"
                        onclick="limpiarFirma()"
                        class="text-sm text-blue-600 hover:underline">
                    Limpiar firma
                </button>
            </div>

            <button type="submit"
                    class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Firmar Documento
            </button>
        </form>
    </section>

</div>

<script>
    const canvas = document.getElementById('canvasFirma');
    const ctx = canvas.getContext('2d');
    let dibujando = false;

    function pos(e) {
        const r = canvas.getBoundingClientRect();
        return {
            x: e.clientX - r.left,
            y: e.clientY - r.top
        };
    }

    canvas.addEventListener('mousedown', e => {
        dibujando = true;
        const p = pos(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    });

    canvas.addEventListener('mousemove', e => {
        if (!dibujando) return;
        const p = pos(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
    });

    canvas.addEventListener('mouseup', () => dibujando = false);
    canvas.addEventListener('mouseleave', () => dibujando = false);

    function limpiarFirma() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('firma').value = '';
    }

    document.querySelector('form').addEventListener('submit', e => {
        const data = ctx.getImageData(0,0,canvas.width,canvas.height).data;
        if (![...data].some(v => v !== 0)) {
            e.preventDefault();
            alert('Debe firmar antes de continuar.');
            return;
        }
        document.getElementById('firma').value = canvas.toDataURL('image/png');
    });
</script>

</body>
</html>
