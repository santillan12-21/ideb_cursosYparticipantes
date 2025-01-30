<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            color: #2c3e50;
            font-size: 32px;
        }
        h5 {
            color: #34495e;
            font-size: 24px;
            font-weight: bold;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 16px;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .info-general-title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }
        .info-title {
            font-size: 16px;
            font-weight: bold;
        }
        .info-text {
            text-align: justify;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <img src="{{ public_path('images/logo4.jpg') }}" alt="Logo" class="logo mb-4">
        <h1>Detalles del Curso: {{ $curso->NombredelCurso }}</h1>

        <div class="card my-4">
            <div class="card-body">
                <h5>Información General</h5>
                <p class="info-text"><span class="info-title">Nomenclatura:</span> {{ $curso->Nomenclatura }}</p>
                <p class="info-text"><span class="info-title">Descripción:</span> {{ $curso->DescripciondeCurso }}</p>
                <p class="info-text"><span class="info-title">Costo:</span> ${{ number_format($curso->CostodelCurso, 2) }}</p>
                <p class="info-text"><span class="info-title">Instructor Responsable:</span> {{ $curso->InstructorResponsable }}</p>
                <p class="info-text"><span class="info-title">Fecha de Inicio:</span> {{ \Carbon\Carbon::parse($curso->FechadeInicio)->format('d/m/Y') }}</p>
                <p class="info-text"><span class="info-title">Fecha de Término:</span> {{ \Carbon\Carbon::parse($curso->FechadeTermino)->format('d/m/Y') }}</p>
                <p class="info-text"><span class="info-title">Duración:</span> {{ $curso->Duracioncurso }}</p>

                <h5>Modalidad</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Virtual</th>
                            <th>Presencial</th>
                            <th>Mixto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $curso->Virtual == 'Si' ? 'Sí' : 'No' }}</td>
                            <td>{{ $curso->Presencial == 'Si' ? 'Sí' : 'No' }}</td>
                            <td>{{ $curso->Mixto == 'Si' ? 'Sí' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5>Formato de Flyer / Imagen</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sin Fecha</th>
                            <th>Facebook</th>
                            <th>Linkedin</th>
                            <th>Instagram</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $curso->SinFecha }}</td>
                            <td>{{ $curso->Facebook }}</td>
                            <td>{{ $curso->Linkedin }}</td>
                            <td>{{ $curso->Instagram }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5>Documentos del Curso</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Presentación</th>
                            <th>Temario</th>
                            <th>Itinerario</th>
                            <th>Planeación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $curso->Presentación }}</td>
                            <td>{{ $curso->Temario }}</td>
                            <td>{{ $curso->Itinerario }}</td>
                            <td>{{ $curso->Planeación }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5>Material de Apoyo</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Digital</th>
                            <th>Impreso Presentable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $curso->Digital }}</td>
                            <td>{{ $curso->Impreso_Presentable }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5 style="font-size: 28px; color: #2c3e50;">Documentos de Evaluación</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Evaluación Diagnóstica</th>
                            <th>Evaluación de Satisfacción</th>
                            <th>Evaluación Final</th>
                            <th>DC3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $curso->Evaluación_diagnostica }}</td>
                            <td>{{ $curso->EvaluaciondeSatisfacción }}</td>
                            <td>{{ $curso->EvaluacionFinal }}</td>
                            <td>{{ $curso->DC3 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
