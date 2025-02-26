<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 6</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        header {
            background-color: #000000;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }

        header img {
            width: 100px;
            height: auto;
        }

        .modal-header {
            background-color: #000;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 1rem;
        }
        .modal-header img {
            background-color: transparent;
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .modal-body {
            text-align: center;
            font-size: 16px;
        }
        .step-indicator {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .step {
            font-size: 14px;
            color: #777;
            font-weight: bold;
        }
        .step.active {
            color: #007bff;
        }
        .support-text {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        .modal-dialog {
            max-width: 80%;
            max-height: 90vh;
        }
        .modal-content {
            height: 90%;
        }
        .modal-body {
            height: calc(100% - 120px);
            overflow-y: auto;
        }
        .modal-footer {
            display: flex;
            justify-content: center;
        }
        .buttons-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .form-container {
            padding-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Documentos de Evaluación</h3>
                <form action="{{ route('curso.paso6.guardar') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Porcentaje de la Presentación</label>
                        <input type="text" name="Presentación" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local - Presentación</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Presentacion')">Crear carpeta local</button>
                        <div id="archivoPresentacionContainer" style="display: none;" class="mt-2">
                            <input type="file" name="PresentacionLocal" class="form-control">
                            @if(session('cursos_paso6.PresentacionLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso6.PresentacionLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Porcentaje de la Evaluación Diagnóstica</label>
                        <input type="text" name="Evaluación_diagnostica" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local - Evaluación Diagnóstica</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionDiagnostica')">Crear carpeta local</button>
                        <div id="archivoEvaluacionDiagnosticaContainer" style="display: none;" class="mt-2">
                            <input type="file" name="EvaluacionDiagnosticaLocal" class="form-control">
                            @if(session('cursos_paso6.EvaluacionDiagnosticaLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso6.EvaluacionDiagnosticaLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Porcentaje de la Evaluación de Satisfacción</label>
                        <input type="text" name="EvaluaciondeSatisfacción" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local - Evaluación de Satisfacción</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionSatisfaccion')">Crear carpeta local</button>
                        <div id="archivoEvaluacionSatisfaccionContainer" style="display: none;" class="mt-2">
                            <input type="file" name="EvaluacionSatisfaccionLocal" class="form-control">
                            @if(session('cursos_paso6.EvaluacionSatisfaccionLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso6.EvaluacionSatisfaccionLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Porcentaje de la Evaluación Final</label>
                        <input type="text" name="EvaluacionFinal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local - Evaluación Final</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionFinal')">Crear carpeta local</button>
                        <div id="archivoEvaluacionFinalContainer" style="display: none;" class="mt-2">
                            <input type="file" name="EvaluacionFinalLocal" class="form-control">
                            @if(session('cursos_paso6.EvaluacionFinalLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso6.EvaluacionFinalLocal') }}
                                </div>
                            @endif
                        </div>
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

                    <!-- Botones -->
                    <div class="mb-3 d-flex justify-content-between">
                        <!-- Botón Siguiente -->
                        <button type="submit" class="btn btn-success">Siguiente</button>

                        <!-- Botón Atrás -->
                        <a href="{{ route('curso.paso5') }}" class="btn btn-secondary">Atrás</a>

                        <!-- Botón Cancelar -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancelar</button>
                    </div>
                </form>

                <!-- Modal -->
                <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <!-- Encabezado del Modal -->
                            <div class="modal-header">
                                <img src="{{ asset('images/logo3.png') }}" alt="Logo">
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>

                            <!-- Cuerpo del Modal -->
                            <div class="modal-body">
                                <div class="step-indicator">
                                    <div class="step">Paso 1 Datos del Curso</div>
                                    <div class="step">Paso 2 Modalidad del Curso</div>
                                    <div class="step">Paso 3 Formato de Flyer / Imagen</div>
                                    <div class="step">Paso 4 Documentos del Curso</div>
                                    <div class="step">Paso 5 Material de Apoyo</div>
                                    <div class="step active">Paso 6 Documentos de Evaluación</div>
                                    <div class="step">Paso 7 Documentación STPS y Certificados</div>
                                </div>

                                <p>Al dar click a Confirmar se va a borrar toda la informacion y lo regresara a la venta de inicio.</p>

                                <div class="buttons-container">
                                    <a href="{{ route('cursos.index') }}" class="btn btn-primary">Confirmar</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>

                            <!-- Pie de página del Modal -->
                            <div class="modal-footer text-center">
                                Soporte y servicios técnicos y de ingeniería.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function crearCarpeta(tipo) {
            fetch('/crear-carpeta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tipo: tipo,
                    nombreCarpeta: tipo
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Carpeta creada exitosamente: ' + data.ruta);
                    // Mostrar el contenedor de archivos correspondiente
                    const contenedor = document.getElementById(`archivo${tipo.replace('ó', 'o')}Container`);
                    if (contenedor) {
                        contenedor.style.display = 'block';
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
