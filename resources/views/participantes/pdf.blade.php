<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Participante</title>
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
        <!-- Logo -->
        <img src="{{ public_path('images/logo4.jpg') }}" alt="Logo" class="logo mb-4">

        <!-- Título Principal -->
        <h1>Detalles del Participante: {{ $participante->NombredelPostulante }}</h1>

        <!-- Información General -->
        <div class="card my-4">
            <div class="card-body">
                <h5>Información General</h5>
                <p class="info-text"><span class="info-title">Nombre:</span> {{ $participante->NombredelPostulante }}</p>
                <p class="info-text"><span class="info-title">Correo Electrónico:</span> {{ $participante->Correo }}</p>
                <p class="info-text"><span class="info-title">Teléfono:</span> {{ $participante->Telefono }}</p>
                <p class="info-text"><span class="info-title">Edad:</span> {{ $participante->Edad }}</p>
                <p class="info-text"><span class="info-title">Dirección:</span> {{ $participante->Direccion }}</p>
                <p class="info-text"><span class="info-title">Escolaridad:</span> {{ $participante->Escolaridad }}</p>
                <p class="info-text"><span class="info-title">CURP:</span> {{ $participante->Curp }}</p>
                <p class="info-text"><span class="info-title">Razón Social:</span> {{ $participante->RazónSocial }}</p>
                <p class="info-text"><span class="info-title">Empresa:</span> {{ $participante->Empresa }}</p>
                <p class="info-text"><span class="info-title">RFC Empresa:</span> {{ $participante->RFCEmpresa }}</p>
                <p class="info-text"><span class="info-title">Puesto:</span> {{ $participante->Puesto }}</p>
                <p class="info-text"><span class="info-title">Pago:</span> ${{ number_format($participante->Pago, 2) }}</p>
                <p class="info-text"><span class="info-title">Estado de Pago:</span> {{ $participante->EstadoDePago }}</p>
                <p class="info-text"><span class="info-title">Fecha del Curso:</span> {{ \Carbon\Carbon::parse($participante->FechadelCurso)->format('d/m/Y') }}</p>

                <!-- Cursos Inscritos -->
                <h5>Cursos Inscritos</h5>
                @if($participante->cursos->isEmpty())
                    <p class="info-text">No hay cursos inscritos.</p>
                @else
                    @foreach($participante->cursos as $curso)
                        <p class="info-text">
                            <span class="info-title">{{ $curso->NombredelCurso }}:</span>
                            Fecha del Curso: {{ \Carbon\Carbon::parse($curso->pivot->FechadelCurso)->format('d/m/Y') }}
                        </p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</body>
</html>
