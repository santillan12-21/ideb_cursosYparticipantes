<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 5</title>
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
                <h3 class="text-center mb-4">Material de Apoyo</h3>
                <form action="{{ route('curso.paso5.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Digital -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje de material digital</label>
                        <input type="text" name="Digital" class="form-control"  value="{{ old('Digital', $curso->Digital ?? ($datosPadre->Digital ?? '')) }}" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveDigital" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local - Digital</label>
                        @if (!empty($archivosLocales['Materialdeapoyo']) && $archivosLocales['Materialdeapoyo'] === 'actual')
                            <div class="alert alert-success p-2">
                                Este archivo ya fue subido en el curso original
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Digital')">Subir archivo actualizado</button>
                            <div id="archivoDigitalContainer" style="display:none;" class="mt-2">
                                <input type="file" name="DigitalLocal" class="form-control">
                                <div class="mt-2">
                                     {{ session('cursos_paso5.DigitalLocal') }}
                                </div>
                            </div>
                        @else
                            <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Digital')">Crear carpeta local</button>
                            <div id="archivoDigitalContainer" style="display:none;" class="mt-2">
                                <input type="file" name="DigitalLocal" class="form-control">
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso5.DigitalLocal') ?? 'No hay archivo subido' }}
                                </div>
                            </div>
                        @endif

                    </div>



                    <!-- Impreso Presentable (Cambiar para que si hay 5 participanetes muestre un select con la cuenta de los archivos que tienen impresos) -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje del material impreso y presentable</label>
                        <input type="text" name="Impreso_Presentable" class="form-control" value="{{ old('Impreso_Presentable', $curso->Impreso_Presentable ?? ($datosPadre->Impreso_Presentable ?? '')) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo Local - Impreso Presentable</label>
                         @if (!empty($archivosLocales['cursoenlinea']) && $archivosLocales['cursoenlinea'] === 'actual')           
                             <div class="alert alert-success p-2">
                                Este archivo ya fue subido en el curso original
                            </div>
                        @else
                        <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('ImpresoPresentable')">Crear carpeta local</button>
                        <div id="archivoImpresoPresentableContainer" style="display: none;" class="mt-2">
                            <input type="file" name="ImpresoPresentableLocal" class="form-control">
                       

                                <div class="mt-2">
                                     {{ session('cursos_paso5.ImpresoPresentableLocal')  }}
                                </div>
                           
                        </div>
                         @endif
                    </div>
                    <!-- Botones -->
                    <div class="mb-3 d-flex justify-content-between">
                        <!-- Botón Siguiente -->
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <!-- Botón Atrás -->
                        <a href="{{ route('curso.paso4') }}" class="btn btn-secondary">Atrás</a>
                        <!-- Botón Cancelar -->
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
                                    <div class="step active">Paso 5 Material de Apoyo</div>
                                    <div class="step">Paso 6 Documentos de Evaluación</div>
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
    const nombresCarpetas = {
        'Digital': '2- Material de Apoyo (Digital)',
        'ImpresoPresentable': '8- Curso en Linea'
    };

    const nombreCarpeta = nombresCarpetas[tipo];

    if (!nombreCarpeta) {
        alert('Error: Tipo de carpeta no reconocido.');
        return;
    }

    fetch('/crear-carpeta', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tipo: tipo,
            nombreCarpeta: nombreCarpeta
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Carpeta creada exitosamente: ' + data.ruta);

            // Mapear tipo a id correcto para mostrar contenedor
            const idMap = {
                'Digital': 'archivoDigitalContainer',
                'ImpresoPresentable': 'archivoImpresoPresentableContainer'
            };

            const contenedorId = idMap[tipo];
            const contenedor = document.getElementById(contenedorId);
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
