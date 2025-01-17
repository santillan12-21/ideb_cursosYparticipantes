<!-- resources/views/cursos/paso5.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Documentos del Curso</h3>
                <form action="{{ route('curso.paso4.guardar') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Temario</label>
                        <input type="text" name="Temario" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Temario</label>
                        <input type="text" name="DriveTemario" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Itinerario</label>
                        <input type="text" name="Itinerario" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Itinerario</label>
                        <input type="text" name="DriveItinerario" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Planeación</label>
                        <input type="text" name="Planeación" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Planeación</label>
                        <input type="text" name="DrivePlaneación" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <a href="{{ route('curso.paso3') }}" class="btn btn-secondary">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
