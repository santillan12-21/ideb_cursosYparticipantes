<!-- resources/views/cursos/crear_paso1.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="w-50">
            <h3 class="text-center mb-4">Crear Curso</h3>
            <form action="{{ route('curso.paso1.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="Nomenclatura" class="form-control" placeholder="Nomenclatura" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="NombredelCurso" class="form-control" placeholder="Nombre del Curso" required>
                </div>

                <div class="mb-3">
                    <textarea name="DescripciondeCurso" class="form-control" rows="3" placeholder="Descripción del Curso" required></textarea>
                </div>

                <div class="mb-3">
                    <input type="number" step="0.01" name="CostodelCurso" class="form-control" placeholder="Costo del Curso ($)" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="InstructorResponsable" class="form-control" placeholder="Instructor Responsable" required>
                </div>

                <div class="mb-3">
                    <input type="date" name="FechadeInicio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="date" name="FechadeTermino" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="/cursos" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
