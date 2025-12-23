<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<p>Estimado/a,</p>

<p>
    Se ha registrado una ficha de prácticas pre profesionales que requiere
    <strong>el visto bueno de la empresa</strong>.
</p>

<p>
    Empresa: <strong>{{ $token->ficha->razon_social }}</strong><br>
    Alumno: <strong>{{ $token->ficha->alumno->nombre_completo }}</strong>
</p>

<p>
    👉 Para firmar el documento, haga clic en el siguiente enlace:
</p>

<p>
    <a href="{{ route('firmas.show', $token->token) }}">
        Firmar Ficha de Prácticas
    </a>
</p>

<p>
    Este enlace es personal y expira el {{ $token->expires_at->format('d/m/Y H:i') }}.
</p>

<p>Atentamente,<br>
    Programa de Informática</p>
</body>
</html>
