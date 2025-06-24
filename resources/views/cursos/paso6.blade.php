<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 6</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logoibeb.ico') }}">

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
                <form action="{{ route('curso.paso6.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Presentación -->
                    <div class="form-section">
                        <h5>Presentación</h5>

                        <!-- Porcentaje -->
                        <div class="mb-3">
                            <label class="form-label">Porcentaje de la Presentación</label>
                            <input type="text" name="Presentación" class="form-control"
                                value="{{ old('Presentación') ?? ($curso->Presentación ?? ($datosPadre->Presentación ?? '')) }}">
                        </div>

                        <!-- Drive URL -->
                        <div class="mb-3">
                            <label class="form-label">URL Drive (opcional)</label>
                            <input type="text" name="DrivePresentacion" class="form-control"
                                value="{{ old('DrivePresentacion') ?? ($curso->DrivePresentacion ?? '') }}">
                        </div>

                        <!-- Archivo Local -->
                        <div class="mb-3">
                            <label class="form-label">Archivo Local (opcional)</label>
                            @if ($archivosLocales['presentacion'] === 'actual')
                                <div class="alert alert-success p-2">
                                    Este archivo ya fue subido en el curso original
                                </div>

                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Presentacion')">
                                    Subir archivo actualizado
                                </button>
                                <div id="archivoPresentacionContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="PresentacionLocal" class="form-control">
                                </div>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Presentacion')">
                                    Subir archivo local
                                </button>
                                <div id="archivoPresentacionContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="PresentacionLocal" class="form-control">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Evaluación Diagnóstica -->
                    <div class="form-section">
                        <h5>Evaluación Diagnóstica</h5>

                        <div class="mb-3">
                            <label class="form-label">Porcentaje</label>
                            <input type="text" name="Evaluación_diagnostica" class="form-control"
                                value="{{ old('Evaluación_diagnostica') ?? ($curso->Evaluación_diagnostica ?? ($datosPadre->Evaluación_diagnostica ?? '')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Drive (opcional)</label>
                            <input type="text" name="DriveEvaluacionDiagnostica" class="form-control"
                                value="{{ old('DriveEvaluacionDiagnostica') ?? ($curso->DriveEvaluacionDiagnostica ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Archivo Local (opcional)</label>
                            @if ($archivosLocales['EvaluacionDiagnosticaLocal'] === 'actual')
                                <div class="alert alert-success p-2">Este archivo ya fue subido en el curso original</div>

                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionDiagnostica')">
                                    Subir archivo actualizado
                                </button>
                                <div id="archivoEvaluacionDiagnosticaContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="EvaluacionDiagnosticaLocal" class="form-control">
                                </div>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionDiagnostica')">
                                    Subir archivo local
                                </button>
                                <div id="archivoEvaluacionDiagnosticaContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="EvaluacionDiagnosticaLocal" class="form-control">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Evaluación de Satisfacción -->
                    <div class="form-section">
                        <h5>Evaluación de Satisfacción</h5>

                        <div class="mb-3">
                            <label class="form-label">Porcentaje</label>
                            <input type="text" name="EvaluaciondeSatisfacción" class="form-control"
                                value="{{ old('EvaluaciondeSatisfacción') ?? ($curso->EvaluaciondeSatisfacción ?? ($datosPadre->EvaluaciondeSatisfacción ?? '')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Drive (opcional)</label>
                            <input type="text" name="DriveEvaluacionSatisfaccion" class="form-control"
                                value="{{ old('DriveEvaluacionSatisfaccion') ?? ($curso->DriveEvaluacionSatisfaccion ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Archivo Local (opcional)</label>
                            @if ($archivosLocales['EvaluacionSatisfaccionLocal'] === 'actual')
                                <div class="alert alert-success p-2">Este archivo ya fue subido en el curso original</div>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionSatisfaccion')">
                                    Subir archivo actualizado
                                </button>
                                <div id="archivoEvaluacionSatisfaccionContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="EvaluacionSatisfaccionLocal" class="form-control">
                                </div>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionSatisfaccion')">
                                    Subir archivo local
                                </button>
                                <div id="archivoEvaluacionSatisfaccionContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="EvaluacionSatisfaccionLocal" class="form-control">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Evaluación Final -->
                    <div class="form-section">
                        <h5>Evaluación Final</h5>

                        <div class="mb-3">
                            <label class="form-label">Porcentaje</label>
                            <input type="text" name="EvaluacionFinal" class="form-control"
                                value="{{ old('EvaluacionFinal') ?? ($curso->EvaluacionFinal ?? ($datosPadre->EvaluacionFinal ?? '')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Drive (opcional)</label>
                            <input type="text" name="DriveEvaluacionFinal" class="form-control"
                                value="{{ old('DriveEvaluacionFinal') ?? ($curso->DriveEvaluacionFinal ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Archivo Local (opcional)</label>
                            @if ($archivosLocales['EvaluacionFinalLocal'] === 'actual')
                                <div class="alert alert-success p-2">Este archivo ya fue subido en el curso original</div>
                                 <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionFinal')">
                                    Subir archivo actualizado
                                </button>
                                <div id="archivoEvaluacionFinalContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="EvaluacionFinalLocal" class="form-control">
                                </div>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('EvaluacionFinal')">
                                    Subir archivo local
                                </button>
                                <div id="archivoEvaluacionFinalContainer" style="display: none;" class="file-upload-container mt-2">
                                    <input type="file" name="EvaluacionFinalLocal" class="form-control">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- DC3 -->
                    <div class="form-section">
                        <h5>DC3</h5>

                        <div class="mb-3">
                            <label class="form-label">Estado del DC3</label>
                            <select name="DC3" class="form-select" required>
                                <option value="" disabled selected>Seleccione el estado del DC3</option>
                                <option value="Se entrega DC3" {{ old('DC3') == 'Se entrega DC3' ? 'selected' : '' }}>Se entrega DC3</option>
                                <option value="No se entrega DC3" {{ old('DC3') == 'No se entrega DC3' ? 'selected' : '' }}>No se entrega DC3</option>
                                <option value="Entrega pendiente de DC3" {{ old('DC3') == 'Entrega pendiente de DC3' ? 'selected' : '' }}>Entrega pendiente de DC3</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mb-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <a href="{{ route('curso.paso5') }}" class="btn btn-secondary">Atrás</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancelar</button>
                        <button type="button" class="btn btn-warning" id="finalizarForzadoBtn">Finalización Forzada</button>
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
        // Validar que el tipo sea uno de los permitidos
        const tiposPermitidos = ['EvaluacionDiagnostica', 'EvaluacionSatisfaccion', 'EvaluacionFinal', 'Presentacion'];
        if (!tiposPermitidos.includes(tipo)) {
            alert('Error: Tipo de carpeta no válido.');
            return;
        }

        // Realizar la solicitud POST al servidor para crear la carpeta
        fetch('/crear-carpeta', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                tipo: tipo // Enviar el tipo de carpeta al servidor
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('finalizarForzadoBtn').addEventListener('click', function () {
            // Mostrar mensaje de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esto guardará el curso como incompleto y no podrás continuar editándolo.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar ahora',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar los datos actuales del formulario mediante AJAX
                    const formData = new FormData(document.querySelector('form'));

                    fetch('/curso/finalizacion-forzada', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Curso guardado',
                                text: 'El curso ha sido guardado como incompleto.'
                            }).then(() => {
                                window.location.href = "{{ route('cursos.index') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud.'
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
