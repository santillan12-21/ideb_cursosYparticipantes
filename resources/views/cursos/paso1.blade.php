<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario - Crear Curso</title>
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

    <div class="container d-flex justify-content-center align-items-center form-container">
        <div class="w-50">
            <h3 class="text-center mb-4">Datos del Curso</h3>
            <form action="{{ route('curso.paso1.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="Nomenclatura" class="form-label fw-bold small text-uppercase text-muted">Nomenclatura del Curso</label>
                    <input type="text" name="Nomenclatura" id="Nomenclatura" class="form-control @error('Nomenclatura') is-invalid @enderror"
                        placeholder="Ingrese la nomenclatura manualmente" value="{{ old('Nomenclatura', session('nomenclatura_generada')) }}" required>
                    @error('Nomenclatura')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="NombredelCurso" class="form-control @error('NombredelCurso') is-invalid @enderror" placeholder="Nombre del Curso"   value="{{ old('NombredelCurso', $curso->NombredelCurso ?? '') }}" required>
                    @error('NombredelCurso')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                <textarea name="DescripciondeCurso" class="form-control" rows="3" placeholder="Descripción del Curso" required>
                {{ old('DescripciondeCurso', $curso->DescripciondeCurso ?? ($datosPadre->DescripciondeCurso ?? '')) }}
                </textarea>  
                </div>
                <div class="mb-3">
                <input type="number" step="0.01" name="CostodelCurso" class="form-control"
                value="{{ old('CostodelCurso', $curso->CostodelCurso ?? ($datosPadre->CostodelCurso ?? '')) }}"
                placeholder="Costo del Curso ($)" required>               
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
                <div class="mb-3">
                    <input type="text" name="Duracioncurso" class="form-control" placeholder="Duración del Curso (ej: 9 horas)" required>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Siguiente</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancelar</button>
                    <button type="button" class="btn btn-warning" id="finalizarForzadoBtn">Finalización Forzada</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('images/logo3.png') }}" alt="Logo">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="step-indicator">
                        <div class="step active">Paso 1 Datos del Curso</div>
                        <div class="step">Paso 2 Modalidad del Curso</div>
                        <div class="step">Paso 3 Formato de Flyer / Imagen</div>
                        <div class="step">Paso 4 Documentos del Curso</div>
                        <div class="step">Paso 5 Material de Apoyo</div>
                        <div class="step">Paso 6 Documentos de Evaluación</div>
                        <div class="step">Paso 7 Documentación STPS y Certificados</div>
                    </div>

                    <p>Al dar click a Confirmar se va a borrar toda la informacion y lo regresara a la venta de inicio.</p>

                    <div class="buttons-container">
                        <a href="{{ route('cursos.index') }}" class="btn btn-primary">Confirmar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="support-text">
                        Soporte y servicios técnicos y de ingeniería.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
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
</html>
