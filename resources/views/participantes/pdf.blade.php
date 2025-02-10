<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Participante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative; /* Necesario para posicionar el logo */
        }
        .letterhead {
            position: relative;
            padding: 20px;
        }
        .letterhead-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative; /* Necesario para posicionar el logo */
            z-index: 1; /* Asegura que el contenido esté encima del logo */
        }
        .logo-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30px; /* Reducido a 30px para hacer el logo más pequeño */
            height: auto;
            opacity: 0.1; /* Reduce la opacidad para que el logo sea un fondo difuminado */
            z-index: 0; /* Asegura que el logo esté detrás del contenido */
            pointer-events: none; /* Evita que el logo interfiera con clics u otros eventos */
        }
        .logo {
            width: 250px;
            margin-right: 20px;
        }
        .logo img {
            width: 100%;
            height: auto;
        }
        .contact-info {
            text-align: right;
            color: #333;
            font-size: 12px;
        }
        .letterhead-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('path/to/diagonal-background.png') no-repeat top right;
            z-index: -1;
        }
        .letterhead-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .card h5 {
            font-size: 18px;
            color: #000;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .info-text {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }
        .info-text .info-title {
            font-weight: bold;
            color: #000;
        }
        .contact-info {
            display: flex;
            align-items: center;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }
        .contact-item img {
            width: 20px;
            margin-right: 5px;
        }
        .contact-item span {
            color: blue;
        }
        /* Estilo para la marca de tiempo */
        .timestamp {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }
        /* Reglas específicas para la impresión */
        @media print {
            .timestamp {
                display: block !important; /* Asegura que el elemento sea visible */
                text-align: right;
                font-size: 12px;
                color: #000; /* Cambia el color a negro para mayor visibilidad en impresión */
            }
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <div class="letterhead-background"></div>
        <!-- Logo como fondo -->
        <div class="logo-background">
            <img src="{{ public_path('images/logo4.jpg') }}" alt="Logo IDEB">
        </div>
        <div class="letterhead-top">
            <div class="logo">
                <img src="{{ public_path('images/logo4.jpg') }}" alt="Logo IDEB">
            </div>
            <div class="contact-info">
                <div class="contact-item">
                    <img src="{{ public_path('images/phone-icon.png') }}" alt="Teléfono">
                    <span>33 2343 5465</span>
                </div>
                <div class="contact-item">
                    <img src="{{ public_path('images/email-icon.png') }}" alt="Correo">
                    <span>JMesarGJ@gmail.com</span>
                </div>
            </div>
        </div>
        <div class="letterhead-bottom">
            Instituto de Capacitación Industrial
        </div>
    </div>
    <div class="container">
        <!-- Previous content remains the same -->
        <div class="card">
            <h5>Detalles del Participante: {{ $participante->NombredelPostulante }}</h5>
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
        </div>
        <!-- Cursos Inscritos -->
        <div class="card">
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
        <!-- Marca de tiempo -->
        <div class="timestamp">
            Impreso el: {{ \Carbon\Carbon::now('America/Mexico_City')->format('d/m/Y h:i:s A') }}
        </div>
    </div>
</body>
</html>
