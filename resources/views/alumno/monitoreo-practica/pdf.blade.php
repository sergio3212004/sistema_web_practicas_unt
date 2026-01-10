<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo de Prácticas - Semana {{ $monitoreoPractica->semana->numero }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 15px;
        }

        /* Header con logo */
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .logo-container {
            margin-bottom: 8px;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .header h1 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header h2 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header h3 {
            font-size: 11px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .formato-label {
            font-size: 10px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 3px 8px;
            display: inline-block;
            border: 1px solid #000;
        }

        /* Secciones */
        .section {
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 6px;
            text-decoration: underline;
        }

        .field-group {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .field {
            display: table-row;
        }

        .field-label {
            display: table-cell;
            font-weight: bold;
            padding: 2px 5px 2px 0;
            white-space: nowrap;
        }

        .field-value {
            display: table-cell;
            border-bottom: 1px solid #000;
            padding: 2px 5px;
            width: 100%;
        }

        .field-inline {
            display: inline-block;
            margin-right: 15px;
        }

        /* Tabla de actividades */
        .activities-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .activities-table th,
        .activities-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .activities-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
        }

        .activities-table td {
            font-size: 10px;
        }

        .activities-table .actividad-col {
            text-align: left;
            width: 30%;
        }

        .activities-table .observacion-col {
            text-align: left;
            width: 20%;
        }

        .activities-table .fecha-col {
            width: 10%;
        }

        .activities-table .nro-col {
            width: 5%;
        }

        .activities-table .avance-col {
            width: 8%;
        }

        .activities-table .firma-col {
            width: 13%;
        }

        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin: 0 3px;
            vertical-align: middle;
        }

        .checkbox.checked::after {
            content: 'X';
            display: block;
            text-align: center;
            font-weight: bold;
            line-height: 12px;
        }

        .firma-img {
            max-width: 80px;
            max-height: 40px;
            margin: 0 auto;
        }

        /* Grid de 2 columnas para campos */
        .two-columns {
            display: table;
            width: 100%;
        }

        .column {
            display: table-cell;
            width: 50%;
            padding-right: 10px;
        }

        .column:last-child {
            padding-right: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-aldia {
            background-color: #d4edda;
            color: #155724;
        }

        .status-atrasado {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- HEADER -->
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('images/UNT.png') }}" alt="Logo UNT" class="logo">
        </div>
        <h1>FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS</h1>
        <h2>PROGRAMA DE INFORMÁTICA</h2>
        <h3>MONITOREO DE PRÁCTICAS PRE PROFESIONALES</h3>
        <div class="formato-label">FORMATO 03: MONITOREO DE PRÁCTICAS</div>
    </div>

    <!-- SECCIÓN: DEL ESTUDIANTE -->
    <div class="section">
        <div class="section-title">DEL ESTUDIANTE:</div>
        <div class="two-columns">
            <div class="column">
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Apellidos y Nombres:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->user->nombre }}</span>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Celular:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->user->telefono ?? 'No registrado' }}</span>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Nro. Matrícula:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->codigo_matricula }}</span>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Correo:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->user->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN: DE LA EMPRESA -->
    <div class="section">
        <div class="section-title">DE LA EMPRESA DONDE REALIZA LA PRÁCTICA:</div>
        <div class="field-group">
            <div class="field">
                <span class="field-label">Razón Social:</span>
                <span class="field-value">{{ $monitoreoPractica->alumno->fichaRegistro->razon_social }}</span>
            </div>
        </div>
        <div class="field-group">
            <div class="field">
                <span class="field-label">Área o unidad donde se realizará la práctica:</span>
                <span class="field-value">{{ $monitoreoPractica->alumno->fichaRegistro->area_practicas }}</span>
            </div>
        </div>
    </div>

    <!-- SECCIÓN: DEL JEFE DIRECTO -->
    <div class="section">
        <div class="section-title">DEL JEFE DIRECTO DEL PRACTICANTE:</div>
        <div class="field-group">
            <div class="field">
                <span class="field-label">Nombre:</span>
                <span class="field-value">{{ $monitoreoPractica->alumno->fichaRegistro->nombre_jefe_directo }}</span>
            </div>
        </div>
        <div class="two-columns">
            <div class="column">
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Cargo:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->fichaRegistro->cargo ?? 'No especificado' }}</span>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Celular:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->fichaRegistro->telefono_jefe_directo }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="field-group">
            <div class="field">
                <span class="field-label">Correo:</span>
                <span class="field-value">{{ $monitoreoPractica->alumno->fichaRegistro->correo_jefe_directo }}</span>
            </div>
        </div>
    </div>

    <!-- SECCIÓN: DEL PROFESOR SUPERVISOR -->
    <div class="section">
        <div class="section-title">DEL PROFESOR SUPERVISOR:</div>
        <div class="field-group">
            <div class="field">
                <span class="field-label">Nombre:</span>
                <span class="field-value">{{ $monitoreoPractica->alumno->aula->profesor->user->nombre ?? 'No asignado' }}</span>
            </div>
        </div>
        <div class="two-columns">
            <div class="column">
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Celular:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->aula->profesor->user->telefono ?? 'No registrado' }}</span>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field-group">
                    <div class="field">
                        <span class="field-label">Correo:</span>
                        <span class="field-value">{{ $monitoreoPractica->alumno->aula->profesor->user->email ?? 'No asignado' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE ACTIVIDADES -->
    <table class="activities-table">
        <thead>
        <tr>
            <th class="nro-col">Nro</th>
            <th class="fecha-col">Fecha</th>
            <th class="actividad-col">Actividad</th>
            <th colspan="2" class="avance-col">Nivel de avance del<br>Plan de Práctica<br>Pre Profesional</th>
            <th class="observacion-col">Observaciones</th>
            <th class="firma-col">Firma<br>Practicante</th>
            <th class="firma-col">Firma<br>Profesor<br>Supervisor</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th style="font-size: 8px;">Atrasado</th>
            <th style="font-size: 8px;">Al día</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($monitoreoPractica->monitoreosPracticasActividades as $index => $actividad)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                <td class="actividad-col">{{ $actividad->cronogramaActividad->actividad }}</td>
                <td>
                    <span class="checkbox {{ !$actividad->al_dia ? 'checked' : '' }}"></span>
                </td>
                <td>
                    <span class="checkbox {{ $actividad->al_dia ? 'checked' : '' }}"></span>
                </td>
                <td class="observacion-col">{{ $actividad->observacion ?? '' }}</td>
                <td>
                    @if($actividad->firma_practicante)
                        <img src="{{ public_path('storage/' . $actividad->firma_practicante) }}"
                             alt="Firma"
                             class="firma-img">
                    @endif
                </td>
                <td>
                    @if($actividad->firma_supervisor)
                        <img src="{{ public_path('storage/' . $actividad->firma_supervisor) }}"
                             alt="Firma"
                             class="firma-img">
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
</body>
</html>
