<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<p>Estimado/a,</p>

<p>
    Se solicita el <strong>V°B° del Programa</strong> para la siguiente ficha:
</p>

<p>
    Alumno: <strong>{{ $token->ficha->alumno->nombre_completo }}</strong><br>
    Empresa: <strong>{{ $token->ficha->razon_social }}</strong>
</p>

<p>
    👉 Acceda al enlace para firmar:
</p>

<p>
    <a href="{{ route('firmas.show', $token->token) }}">
        Firmar Ficha
    </a>
</p>

<p>
    El enlace expira el {{ $token->expires_at->format('d/m/Y H:i') }}.
</p>

<p>Programa de Informática</p>
</body>
</html>
