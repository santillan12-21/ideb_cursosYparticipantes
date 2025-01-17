<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1>Detalles del Curso: {{ $curso->NombredelCurso }}</h1>

        <div class="mb-4">
            <a href="{{ route('cursos.index') }}" class="btn btn-primary">Regresar a la Lista de Cursos</a>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información General</h5>
                <p><strong>Nomenclatura:</strong> {{ $curso->Nomenclatura }}</p>
                <p><strong>Descripción:</strong> {{ $curso->DescripciondeCurso }}</p>
                <p><strong>Costo:</strong> ${{ number_format($curso->CostodelCurso, 2) }}</p>
                <p><strong>Instructor Responsable:</strong> {{ $curso->InstructorResponsable }}</p>
                <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($curso->FechadeInicio)->format('d/m/Y') }}</p>
                <p><strong>Fecha de Término:</strong> {{ \Carbon\Carbon::parse($curso->FechadeTermino)->format('d/m/Y') }}</p>
                <p><strong>Modalidad:</strong>
                    @if($curso->Virtual == 'Si')
                        Virtual
                    @elseif($curso->Presencial == 'Si')
                        Presencial
                    @elseif($curso->Mixto == 'Si')
                        Mixto
                    @else
                        No definido
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>
</html>
