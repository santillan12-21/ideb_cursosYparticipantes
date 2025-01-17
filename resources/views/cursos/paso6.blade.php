<!-- resources/views/cursos/paso6.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 6</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Documentos de Evaluación</h3>
                <form action="{{ route('curso.paso6.guardar') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Presentación</label>
                        <input type="text" name="Presentación" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Evaluación Diagnóstica</label>
                        <input type="text" name="Evaluación_diagnostica" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Evaluación de Satisfacción</label>
                        <input type="text" name="EvaluaciondeSatisfacción" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Evaluación Final</label>
                        <input type="text" name="EvaluacionFinal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">DC3</label>
                        <select name="DC3" class="form-select" required>
                            <option value="" disabled selected>Seleccione el estado del DC3</option>
                            <option value="Tiene DC3">Tiene DC3</option>
                            <option value="No tiene DC3">No tiene DC3</option>
                            <option value="Por confirmar">Por confirmar</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <a href="{{ route('curso.paso5') }}" class="btn btn-secondary">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
