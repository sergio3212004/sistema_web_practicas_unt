<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Firma Registrada</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #e0f2fe, #f8fafc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #ffffff;
            max-width: 520px;
            width: 90%;
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,.15);
            text-align: center;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background-color: #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon svg {
            width: 40px;
            height: 40px;
            color: #16a34a;
        }

        h1 {
            font-size: 22px;
            color: #1f2937;
            margin-bottom: 12px;
        }

        p {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .footer {
            font-size: 13px;
            color: #6b7280;
        }

        .badge {
            display: inline-block;
            background-color: #eff6ff;
            color: #1d4ed8;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 13px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <div class="badge">
        Firma registrada correctamente
    </div>

    <h1>¡Gracias por su validación!</h1>

    <p>
        La firma de la ficha de prácticas pre profesionales ha sido registrada
        exitosamente en el sistema.
    </p>

    <p>
        Ya puede cerrar esta ventana.
        No es necesario realizar ninguna otra acción.
    </p>

    <div class="footer">
        Programa de Informática<br>
        Facultad de Ciencias Físicas y Matemáticas
    </div>
</div>

</body>
</html>
