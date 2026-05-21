@php
    // Obtener el logo desde la configuración
    $setting = \App\Models\Setting::first();
    $logoPath = $setting && $setting->logo ? asset('storage/' . $setting->logo) : asset('images/default-logo.png');
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #000000;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a, .logout-button {
            color: #fff;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }

        nav a:hover, .logout-button:hover {
            text-decoration: underline;
        }

        .logout-button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .container {
            text-align: center;
            padding: 40px;
        }

        h1 {
            margin-bottom: 30px;
            font-size: 2em;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
        }

        .grid a,
        .grid button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 180px;
            height: 50px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .grid a:hover,
        .grid button:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <header>
        <a href="/Inicio">
            <img src="{{ $logoPath }}" alt="Logo de la aplicación" style="width: 200px; height: 70px;">
        </a>
    </header>

    <div class="container py-5">
        <h1>Detalles del Curso: {{ $curso->NombredelCurso }}</h1>

        <div class="mb-4">
            @if(auth()->user()->puesto != 'Operacion')
            <a href="{{ route('cursos.pdf', $curso->id) }}" class="btn btn-secondary">Descargar PDF</a>
            @endif
            <a href="{{ route('cursos.index') }}" class="btn btn-primary">Regresar a la Lista de Cursos</a>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información General</h5>
                <p><strong>Nomenclatura:</strong> {{ $curso->Nomenclatura }}</p>
                <p><strong>Descripción:</strong> {{ $curso->DescripciondeCurso }}</p>
                <p><strong>Costo:</strong> ${{ number_format((float)$curso->CostodelCurso, 2) }}</p>
                <p><strong>Instructor Responsable:</strong> {{ $curso->InstructorResponsable }}</p>
                <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($curso->FechadeInicio)->format('d/m/Y') }}</p>
                <p><strong>Fecha de Término:</strong> {{ \Carbon\Carbon::parse($curso->FechadeTermino)->format('d/m/Y') }}</p>
                <p><strong>Duración: {{ $curso->Duracioncurso}}</strong></p>

                <h5>Modalidad</h5>
                <p><strong>Virtual:</strong> {{ $curso->Virtual == 'Si' ? 'Sí' : 'No' }}</p>
                <p><strong>Presencial:</strong> {{ $curso->Presencial == 'Si' ? 'Sí' : 'No' }}</p>
                <p><strong>Mixto:</strong> {{ $curso->Mixto == 'Si' ? 'Sí' : 'No' }}</p>

                <h5>Formato de Flyer / Imagen</h5>
                <p><strong>Sin Fecha:</strong> {{ $curso->SinFecha }}</p>
                <p><strong>Sin Fecha Drive:</strong> @if($curso->DriveSinFecha) <a href="{{ $curso->DriveSinFecha }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Facebook:</strong> {{ $curso->Facebook }}</p>
                <p><strong>Facebook Drive:</strong> @if($curso->DriveFacebook) <a href="{{ $curso->DriveFacebook }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Linkedin:</strong> {{ $curso->Linkedin }}</p>
                <p><strong>Linkedin Drive:</strong> @if($curso->DriveLinkedin) <a href="{{ $curso->DriveLinkedin }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Instagram:</strong> {{ $curso->Instagram }}</p>
                <p><strong>Instagram Drive:</strong> @if($curso->DriveInstagram) <a href="{{ $curso->DriveInstagram }}" target="_blank">Ver</a> @else No disponible @endif</p>

                <h5>Documentos del Curso</h5>
                <p><strong>Temario:</strong> {{ $curso->Temario }}</p>
                <p><strong>Temario Drive:</strong> @if($curso->DriveTemario) <a href="{{ $curso->DriveTemario }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Itinerario:</strong> {{ $curso->Itinerario }}</p>
                <p><strong>Itinerario Drive:</strong> @if($curso->DriveItinerario) <a href="{{ $curso->DriveItinerario }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Planeación:</strong> {{ $curso->Planeación }}</p>
                <p><strong>Planeación Drive:</strong> @if($curso->DrivePlaneación) <a href="{{ $curso->DrivePlaneación }}" target="_blank">Ver</a> @else No disponible @endif</p>

                <h5>Material de Apoyo</h5>
                <p><strong>Digital:</strong> {{ $curso->Digital }}</p>
                <p><strong>Digital Drive:</strong> @if($curso->DriveDigital) <a href="{{ $curso->DriveDigital }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Impreso Presentable:</strong> {{ $curso->Impreso_Presentable }}</p>

                <h5>Documentos de Evaluación</h5>
                <p><strong>Presentación:</strong> {{ $curso->Presentación }}</p>
                <p><strong>Evaluación Diagnóstica:</strong> {{ $curso->Evaluación_diagnostica }}</p>
                <p><strong>Evaluación de Satisfacción:</strong> {{ $curso->EvaluaciondeSatisfacción }}</p>
                <p><strong>Evaluación Final:</strong> {{ $curso->EvaluacionFinal }}</p>
                <p><strong>DC3:</strong> {{ $curso->DC3 }}</p>

                <h5>Documentación STPS y Certificados</h5>
                <p><strong>Fecha Registro STPS:</strong> {{ $curso->FechadeRegistro_STPS ? \Carbon\Carbon::parse($curso->FechadeRegistro_STPS)->format('d/m/Y') : 'No disponible' }}</p>
                <p><strong>Formato DC5:</strong> @if($curso->Formato_DC5) <a href="{{ $curso->Formato_DC5 }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Formato DC5 - ¿Tiene Firma?:</strong> {{ $curso->Formato_DC5_Tienefirma }}</p>
                <p><strong>Certificado de Comprobación:</strong> {{ $curso->Certificadodecomprobacion }}</p>
                <p><strong>Drive de Certificado de Comprobación:</strong> @if($curso->DrivedeCertificadodecomprobacion) <a href="{{ $curso->DrivedeCertificadodecomprobacion }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>Carta Poder - ¿Tiene Firma?:</strong> {{ $curso->Cartapoder_tienefirma }}</p>
                <p><strong>Drive Carta Poder:</strong> @if($curso->DriveCartapoder) <a href="{{ $curso->DriveCartapoder }}" target="_blank">Ver</a> @else No disponible @endif</p>
                <p><strong>UDEMY:</strong> {{ $curso->UDEMY }}</p>
                <p><strong>Enlace UDEMY:</strong> <a href="{{ $curso->EnlaceUDEMY }}" target="_blank">Ver</a></p>
            </div>
        </div>
    </div>
</body>
</html>
