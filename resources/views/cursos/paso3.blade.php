<!-- resources/views/cursos/paso3.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Formato de Flyer / Imagen</h3>
                <form action="{{ route('curso.paso3.guardar') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Sin Fecha</label>
                        <input type="text" name="SinFecha" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Sin Fecha</label>
                        <input type="text" name="DriveSinFecha" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="text" name="Facebook" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Facebook</label>
                        <input type="text" name="DriveFacebook" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" name="Linkedin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive LinkedIn</label>
                        <input type="text" name="DriveLinkedin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="text" name="Instagram" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Instagram</label>
                        <input type="text" name="DriveInstagram" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <a href="{{ route('curso.paso2') }}" class="btn btn-secondary">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
