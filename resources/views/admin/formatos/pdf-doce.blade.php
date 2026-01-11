@php
    use Illuminate\Support\Facades\Auth;
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formato 12 - Monitoreo de Prácticas Pre Profesionales</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-row {
            margin-bottom: 8px;
            display: flex;
            align-items: baseline;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 200px;
        }

        .info-value {
            display: inline-block;
            border-bottom: 1px dotted #000;
            flex: 1;
            padding-left: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 9pt;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 8px 4px;
            vertical-align: middle;
        }

        td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .col-num {
            width: 30px;
            text-align: center;
        }

        .col-nombre {
            width: 120px;
        }

        .col-sede {
            width: 100px;
        }

        .col-responsable {
            width: 90px;
        }

        .col-contacto {
            width: 100px;
        }

        .col-avance {
            width: 60px;
            text-align: center;
        }

        .col-observaciones {
            width: auto;
        }

        .checkbox-cell {
            text-align: center;
        }

        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin: 0 3px;
        }

        .checkbox.checked::after {
            content: '✓';
            font-weight: bold;
            display: block;
            text-align: center;
            line-height: 12px;
            font-size: 10pt;
        }

        .firma-section {
            margin-top: 40px;
            text-align: center;
        }

        .firma-line {
            border-top: 1px solid #000;
            width: 300px;
            margin: 60px auto 5px auto;
        }

        .firma-text {
            font-weight: normal;
            font-size: 10pt;
        }

        .firma-image {
            max-width: 250px;
            max-height: 80px;
            margin: 0 auto 10px auto;
            display: block;
        }

        @page {
            margin: 20mm 15mm;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>ESCUELA PROFESIONAL - PREGRADO</h1>
    <h2>Monitoreo de Prácticas Pre Profesionales</h2>
</div>

<!-- Información General -->
<div class="info-section">
    <div class="info-row">
        <span class="info-label">FECHA DE MONITOREO:</span>
        <span class="info-value">{{ $formatoDoce->created_at->format('d/m/Y') }}</span>
    </div>

    <div class="info-row">
        <span class="info-label">DOCENTE RESPONSABLE DEL MONITOREO:</span>
        <span class="info-value">{{ Auth::user()->profesor->user->nombre ?? 'N/A' }}</span>
    </div>

    <div class="info-row">
        <span class="info-label">CICLO:</span>
        <span class="info-value">{{ $formatoDoce->aula->ciclo ?? 'N/A' }}</span>
    </div>

    <div class="info-row">
        <span class="info-label">SEMESTRE:</span>
        <span class="info-value">{{ $formatoDoce->aula->semestre->nombre ?? 'N/A' }}</span>
    </div>

    <div class="info-row">
        <span class="info-label">NIVEL DE LA PRÁCTICA PRE PROFESIONAL (INICIAL/INTERMEDIO/AVANZADO):</span>
        <span class="info-value" style="text-transform: uppercase;">{{ $formatoDoce->nivel }}</span>
    </div>
</div>

<!-- Tabla de Estudiantes -->
<table>
    <thead>
    <tr>
        <th class="col-num">N°</th>
        <th class="col-nombre">Apellidos y nombres del estudiante</th>
        <th class="col-sede">Sede de Práctica Pre Profesional</th>
        <th class="col-responsable">Responsable de la Sede de Práctica Pre Profesional</th>
        <th class="col-contacto">Datos de contacto de responsable de la Sede de Práctica Pre Profesional
            (correo/teléfono)
        </th>
        <th class="col-avance" colspan="2">Nivel de avance del Plan de Práctica Pre Profesional</th>
        <th class="col-observaciones">Observaciones</th>
    </tr>
    <tr>
        <th colspan="5"></th>
        <th style="width: 30px;">Atrasado</th>
        <th style="width: 30px;">Al día</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($formatoDoce->formatosDoceAlumnos as $index => $registro)
        <tr>
            <td class="col-num">{{ $index + 1 }}</td>
            <td class="col-nombre">{{ $registro->alumno->nombre_completo }}</td>
            <td class="col-sede">{{ $registro->sede_practica }}</td>
            <td class="col-responsable">{{ $registro->responsable }}</td>
            <td class="col-contacto">{{ $registro->contacto_responsable }}</td>
            <td class="checkbox-cell">
                <span class="checkbox {{ !$registro->al_dia ? 'checked' : '' }}"></span>
            </td>
            <td class="checkbox-cell">
                <span class="checkbox {{ $registro->al_dia ? 'checked' : '' }}"></span>
            </td>
            <td class="col-observaciones">{{ $registro->observaciones ?? '' }}</td>
        </tr>
    @endforeach

    @if($formatoDoce->formatosDoceAlumnos->count() < 5)
        @for($i = $formatoDoce->formatosDoceAlumnos->count(); $i < 5; $i++)
            <tr>
                <td class="col-num">{{ $i + 1 }}</td>
                <td class="col-nombre">&nbsp;</td>
                <td class="col-sede">&nbsp;</td>
                <td class="col-responsable">&nbsp;</td>
                <td class="col-contacto">&nbsp;</td>
                <td class="checkbox-cell"><span class="checkbox"></span></td>
                <td class="checkbox-cell"><span class="checkbox"></span></td>
                <td class="col-observaciones">&nbsp;</td>
            </tr>
        @endfor
    @endif
    </tbody>
</table>

<!-- Firma -->
<div class="firma-section">
    @if($formatoDoce->firma_coordinador)
        <img src="{{ public_path('storage/' . $formatoDoce->firma_coordinador) }}"
             alt="Firma"
             class="firma-image">
    @endif
    <div class="firma-line"></div>
    <p class="firma-text">Firma del Docente Responsable del Monitoreo</p>
</div>

</body>
</html>
