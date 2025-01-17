<!-- resources/views/cursos/paso2.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="w-50">
            <h3 class="text-center mb-4">Modalidad del Curso</h3>
            <form action="{{ route('curso.paso2.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <select name="Virtual" class="form-control" required>
                        <option value="" disabled selected>¿El curso es Virtual?</option>
                        <option value="Si">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <select name="Presencial" class="form-control" required>
                        <option value="" disabled selected>¿El curso es Presencial?</option>
                        <option value="Si">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <select name="Mixto" class="form-control" required>
                        <option value="" disabled selected>¿El curso es Mixto?</option>
                        <option value="Si">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('curso.paso1') }}" class="btn btn-secondary">Atrás</a>
            </form>
        </div>
    </div>
</body>
</html>
