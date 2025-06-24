<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logoibeb.ico') }}">

    <style>
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
        .modal-footer {
            display: flex;
            justify-content: center;
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
                <h3 class="text-center mb-4">Formato de Flyer / Imagen</h3>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('curso.paso3.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                   <!-- Sin Fecha -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje de Sin Fecha</label>
                        <input type="text" name="SinFecha" class="form-control" value="{{ old('SinFecha') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveSinFecha" class="form-control" value="{{ old('DriveSinFecha') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local (opcional)</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpetasLocales()">Crear carpeta local</button>
                        <div id="archivoSinFechaContainer" style="display: {{ isset($carpetasExistentes['SinFecha']) && $carpetasExistentes['SinFecha'] ? 'block' : 'none' }};" class="mt-2">
                            <input type="file" name="SinFechaLocal" class="form-control">
                            @if(session('cursos_paso3.SinFechaLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso3.SinFechaLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Facebook -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje de Facebook</label>
                        <input type="text" name="Facebook" class="form-control" value="{{ old('Facebook') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveFacebook" class="form-control" value="{{ old('DriveFacebook') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local (opcional)</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpetasLocales()">Crear carpeta local</button>
                        <div id="archivoFacebookContainer" style="display: {{ isset($carpetasExistentes['Facebook']) && $carpetasExistentes['Facebook'] ? 'block' : 'none' }};" class="mt-2">
                            <input type="file" name="FacebookLocal" class="form-control">
                            @if(session('cursos_paso3.FacebookLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso3.FacebookLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- LinkedIn -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje de LinkedIn</label>
                        <input type="text" name="Linkedin" class="form-control" value="{{ old('Linkedin') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveLinkedin" class="form-control" value="{{ old('DriveLinkedin') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local (opcional)</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpetasLocales()">Crear carpeta local</button>
                        <div id="archivoLinkedInContainer" style="display: {{ isset($carpetasExistentes['LinkedIn']) && $carpetasExistentes['LinkedIn'] ? 'block' : 'none' }};" class="mt-2">
                            <input type="file" name="LinkedInLocal" class="form-control">
                            @if(session('cursos_paso3.LinkedInLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso3.LinkedInLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje de Instagram</label>
                        <input type="text" name="Instagram" class="form-control" value="{{ old('Instagram') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveInstagram" class="form-control" value="{{ old('DriveInstagram') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local (opcional)</label>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpetasLocales()">Crear carpeta local</button>
                        <div id="archivoInstagramContainer" style="display: {{ isset($carpetasExistentes['Instagram']) && $carpetasExistentes['Instagram'] ? 'block' : 'none' }};" class="mt-2">
                            <input type="file" name="InstagramLocal" class="form-control">
                            @if(session('cursos_paso3.InstagramLocal'))
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso3.InstagramLocal') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class="mb-3 d-flex justify-content-between">
                        <!-- Botón Siguiente -->
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <!-- Botón Atrás -->
                        <a href="{{ route('curso.paso2') }}" class="btn btn-secondary">Atrás</a>
                        <!-- Botón Cancelar -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-warning" id="finalizarForzadoBtn">Finalización Forzada</button>
                    </div>
                </form>

                <!-- Modal de Confirmación para Cancelar -->
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
                                    <div class="step active">Paso 3 Formato de Flyer / Imagen</div>
                                    <div class="step">Paso 4 Documentos del Curso</div>
                                    <div class="step">Paso 5 Material de Apoyo</div>
                                    <div class="step">Paso 6 Documentos de Evaluación</div>
                                    <div class="step">Paso 7 Documentación STPS y Certificados</div>
                                </div>
                                <p>Al dar click a Confirmar se va a borrar toda la información y lo regresará a la venta de inicio.</p>
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
        function crearCarpetasLocales() {
        const tipos = ['SinFecha', 'Facebook', 'LinkedIn', 'Instagram'];
        tipos.forEach(tipo => {
            fetch('{{ route("crear.carpeta.local") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tipo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar la vista sin recargar la página
                    document.querySelector(`#archivo${tipo}Container`).style.display = 'block';
                }
            });
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
