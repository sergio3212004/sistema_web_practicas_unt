<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlace Vencido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-16">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="mb-4">
            <svg class="w-16 h-16 mx-auto text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Enlace Vencido</h1>
        <p class="text-gray-600 mb-6">
            Este enlace de firma expiró el {{ $firmaToken->expires_at->format('d/m/Y') }}.
        </p>
        <p class="text-sm text-gray-500">
            Por favor, contacta al administrador del sistema para solicitar un nuevo enlace.
        </p>
    </div>
</div>
</body>
</html>
