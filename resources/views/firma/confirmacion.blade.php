<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firma Exitosa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-16">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8">
        <div class="text-center mb-6">
            <div class="mb-4">
                <svg class="w-20 h-20 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">¡Firma Exitosa!</h1>
            <p class="text-gray-600">
                Tu firma ha sido registrada correctamente
            </p>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-green-800 mb-2">Detalles de la Firma</h3>
            <div class="text-sm text-green-700 space-y-1">
                <p><strong>Tipo:</strong>
                    @if($tipo === 'jefe_directo')
                        Jefe Directo
                    @elseif($tipo === 'profesor')
                        Profesor Supervisor
                    @endif
                </p>
                <p><strong>Fecha y Hora:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
                <p><strong>Estudiante:</strong> {{ $cronograma->fichaRegistro->alumno->nombre_completo }}</p>
                <p><strong>Empresa:</strong> {{ $cronograma->fichaRegistro->razon_social }}</p>
            </div>
        </div>

        @if(!$cronograma->estaFirmadoCompleto())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-800">
                    <strong>Nota:</strong> El cronograma quedará completamente firmado cuando
                    @if($tipo === 'jefe_directo')
                        el Profesor Supervisor
                    @else
                        el Jefe Directo
                    @endif
                    complete su firma.
                </p>
            </div>
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <strong>¡Cronograma Completo!</strong> Todas las firmas han sido registradas.
                    El documento está listo para su uso.
                </p>
            </div>
        @endif

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Puedes cerrar esta ventana
            </p>
        </div>
    </div>
</div>
</body>
</html>
