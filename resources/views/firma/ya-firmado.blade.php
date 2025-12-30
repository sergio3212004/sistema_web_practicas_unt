<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento Firmado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-16">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="mb-4">
            <svg class="w-16 h-16 mx-auto text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Documento Ya Firmado</h1>
        <p class="text-gray-600 mb-2">
            Este documento ya fue firmado el:
        </p>
        <p class="font-semibold text-lg text-gray-800 mb-6">
            {{ $firmaToken->signed_at->format('d/m/Y H:i') }}
        </p>
        <p class="text-sm text-gray-500">
            No es necesario firmarlo nuevamente.
        </p>
    </div>
</div>
</body>
</html>
