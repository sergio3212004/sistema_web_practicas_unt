<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firma de Plan de Prácticas</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
<div style="background-color: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
    <h1 style="margin: 0; font-size: 24px;">Plan de Prácticas Pre-Profesionales</h1>
    <p style="margin: 5px 0 0 0; font-size: 14px;">Solicitud de Firma Digital</p>
</div>

<div style="background-color: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px;">
    <p style="font-size: 16px; margin-top: 0;">
        @if($datos['tipo'] === 'jefe')
            Estimado/a Jefe Directo,
        @else
            Estimado/a Profesor/a Supervisor/a,
        @endif
    </p>

    <p>Se le solicita su firma digital para aprobar el Plan de Prácticas del siguiente estudiante:</p>

    <div style="background-color: white; padding: 15px; border-left: 4px solid #2563eb; margin: 20px 0;">
        <p style="margin: 5px 0;"><strong>Estudiante:</strong> {{ $datos['alumno'] }}</p>
        <p style="margin: 5px 0;"><strong>Empresa:</strong> {{ $datos['empresa'] }}</p>
        <p style="margin: 5px 0;"><strong>Expira:</strong> {{ $datos['expira'] }}</p>
    </div>

    <p>Para revisar y firmar el cronograma, haga clic en el siguiente botón:</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $datos['url'] }}"
           style="display: inline-block; background-color: #2563eb; color: white; padding: 14px 28px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px;">
            Revisar y Firmar Cronograma
        </a>
    </div>

    <div style="background-color: #fef3c7; border: 1px solid #fbbf24; padding: 12px; border-radius: 6px; margin: 20px 0;">
        <p style="margin: 0; font-size: 14px; color: #92400e;">
            <strong>⚠️ Importante:</strong> Este enlace expirará el <strong>{{ $datos['expira'] }}</strong>
        </p>
    </div>

    <p style="font-size: 14px; color: #6b7280; margin-bottom: 0;">
        Si tiene algún problema con el enlace, puede copiar y pegar la siguiente URL en su navegador:
    </p>
    <p style="font-size: 12px; color: #9ca3af; word-break: break-all; background-color: #f3f4f6; padding: 10px; border-radius: 4px;">
        {{ $datos['url'] }}
    </p>
</div>

<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
    <p style="font-size: 12px; color: #9ca3af; margin: 5px 0;">
        Este es un correo automático, por favor no responder.
    </p>
    <p style="font-size: 12px; color: #9ca3af; margin: 5px 0;">
        Programa de Informática - Facultad de Ciencias Físicas y Matemáticas
    </p>
</div>
</body>
</html>
