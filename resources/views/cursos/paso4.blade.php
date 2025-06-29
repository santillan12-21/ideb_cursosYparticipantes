<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logoibeb.ico') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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
        .form-section {
            margin-bottom: 2rem;
        }
        .form-section h5 {
            margin-bottom: 1rem;
            font-weight: bold;
            color: #020202;
        }
        .btn-create-folder {
            margin-bottom: 1rem;
        }
        .file-upload-container {
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
    </header>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="text-center mb-4">Documentos del Curso</h3>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('curso.paso4.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Temario -->
                <div class="form-section">
                    <h5>Temario</h5>
                    
                    <!-- Porcentaje -->
                    <div class="mb-3">
                        <label class="form-label">Porcentaje del Temario</label>
                        <input type="text" step="0.01" name="Temario" class="form-control"
                            value="{{ old('Temario') ?? ($curso->Temario ?? ($datosPadre->Temario ?? '')) }}">
                    </div>
                    
                    <!-- Drive URL -->
                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveTemario" class="form-control"
                            value="{{ old('DriveTemario') ?? ($curso->DriveTemario ?? '') }}">
                    </div>

                <div class="mb-3">
                    <label class="form-label">Archivo Local (opcional)</label>

              @if ($archivosLocales['Temario'] === 'actual')
                    <div class="alert alert-success p-2">
                        Este archivo ya fue subido en el curso original
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm btn-create-folder" data-tipo="Temario">
                        Subir archivo actualizado
                    </button>

                    {{-- HAZ QUE EL INPUT SEA VISIBLE DIRECTAMENTE --}}
                    <div id="archivoTemarioContainer" class="file-upload-container mt-2">
                        <input type="file" name="TemarioLocal" class="form-control">
                    </div>
                @else
                    <button type="button" class="btn btn-secondary btn-sm btn-create-folder" data-tipo="Temario">
                        Subir archivo local
                    </button>

                    {{-- Este sí inicia oculto porque aún no se ha creado la carpeta --}}
                    <div id="archivoTemarioContainer" style="display: none;" class="file-upload-container mt-2">
                        <input type="file" name="TemarioLocal" class="form-control">
                    </div>
                @endif


                </div>

                </div>


                    <!-- Itinerario -->
                <div class="form-section">
                    <h5>Itinerario</h5>

                    <div class="mb-3">
                        <label class="form-label">Porcentaje del Itinerario</label>
                        <input type="text" name="Itinerario" class="form-control"
                            value="{{ old('Itinerario') ?? ($curso->Itinerario ?? ($datosPadre->Itinerario ?? '')) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Drive (opcional)</label>
                        <input type="text" name="DriveItinerario" class="form-control"
                            value="{{ old('DriveItinerario') ?? ($curso->DriveItinerario ?? ($datosPadre->DriveItinerario ?? '')) }}">
                    </div>

                   <div class="mb-3">
                        <label class="form-label">Archivo Local (opcional)</label>

                        @if ($archivosLocales['Itinerario'] === 'actual')
                            <div class="alert alert-success p-2">
                                Este archivo ya fue subido en el curso original
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm btn-create-folder" data-tipo="Itinerario">
                                Subir archivo actualizado
                            </button>

                            {{-- Mostramos el input directamente --}}
                            <div id="archivoItinerarioContainer" class="file-upload-container mt-2">
                                <input type="file" name="ItinerarioLocal" class="form-control">
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso4.ItinerarioLocal') }}
                                </div>
                            </div>
                        @else
                            <button type="button" class="btn btn-secondary btn-sm btn-create-folder" data-tipo="Itinerario">
                                Crear carpeta local
                            </button>

                            {{-- Oculto hasta que se cree la carpeta --}}
                            <div id="archivoItinerarioContainer" style="display: none;" class="file-upload-container mt-2">
                                <input type="file" name="ItinerarioLocal" class="form-control">
                                <div class="mt-2">
                                    Archivo subido: {{ session('cursos_paso4.ItinerarioLocal') }}
                                </div>
                            </div>
                        @endif
                    </div>


                    <!-- Planeación -->
                        <div class="form-section">
                            <h5>Planeación</h5>

                            <div class="mb-3">
                                <label class="form-label">Porcentaje de la Planeación</label>
                                <input type="text" name="Planeación" class="form-control"
                                    value="{{ old('Planeación') ?? ($curso->Planeación ?? ($datosPadre->Planeación ?? '')) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">URL Drive (opcional)</label>
                                <input type="text" name="DrivePlaneación" class="form-control"
                                    value="{{ old('DrivePlaneación') ?? ($curso->DrivePlaneación ?? ($datosPadre->DrivePlaneación ?? '')) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Archivo Local (opcional)</label>

                                @if ($archivosLocales['Planeacion'] === 'actual')
                                    <div class="alert alert-success p-2">
                                        Este archivo ya fue subido
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-sm btn-create-folder" data-tipo="Planeación">
                                        Subir archivo actualizado
                                    </button>

                                    {{-- Mostrar campo directamente --}}
                                    <div id="archivoPlaneaciónContainer" class="file-upload-container mt-2">
                                        <input type="file" name="PlaneaciónLocal" class="form-control">
                                        <div class="mt-2">
                                            Archivo subido: {{ old('rutaPlaneacion') ?? session('cursos_paso4.PlaneaciónLocal', 'No hay archivo subido') }}
                                        </div>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm btn-create-folder" data-tipo="Planeación">
                                        Crear carpeta local
                                    </button>

                                    {{-- Ocultar hasta que se cree --}}
                                <div id="archivoPlaneaciónContainer" class="file-upload-container mt-2">
                                        <input type="file" name="PlaneaciónLocal" class="form-control">
                                        
                                        <div class="mt-2">
                                          Archivo subido: 
                                            @php
                                                $archivo = old('rutaPlaneacion') ?? session('cursos_paso4.PlaneaciónLocal');
                                            @endphp

                                            @if (is_array($archivo))
                                                {{ $archivo['ruta'] ?? json_encode($archivo) }}
                                            @else
                                                {{ $archivo ?? 'No hay archivo subido' }}
                                            @endif

                                        </div>

                                    </div>
                                @endif
                            </div>

                    <!-- Botones -->
                    <div class="mb-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Siguiente</button>
                        <a href="{{ route('curso.paso3') }}" class="btn btn-secondary">Atrás</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancelar</button>
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
                                    <div class="step">Paso 3 Formato de Flyer / Imagen</div>
                                    <div class="step active">Paso 4 Documentos del Curso</div>
                                    <div class="step">Paso 5 Material de Apoyo</div>
                                    <div class="step">Paso 6 Documentos de Evaluación</div>
                                    <div class="step">Paso 7 Documentación STPS y Certificados</div>
                                </div>
                                <p>Al dar click a Confirmar se va a borrar toda la información y lo regresará a la ventana de inicio.</p>
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
        body: JSON.stringify({ tipo: tipo })
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById(`archivo${tipo}Container`);

        if (data.success) {
            alert("✅ Carpeta creada exitosamente en: " + data.ruta);
            if (container) container.style.display = 'block';
        } else if (data.message.includes("ya existe")) {
            // Si la carpeta ya existe, solo mostramos el input
            alert("⚠️ La carpeta ya existe, puedes subir un archivo nuevo.");
            if (container) container.style.display = 'block';
        } else {
            alert("❌ Error: " + data.message);
        }
    });
}
</script>
<script>
    document.querySelectorAll('.btn-create-folder').forEach(btn => {
        btn.addEventListener('click', function() {
            const tipo = btn.getAttribute('data-tipo');
            const container = document.getElementById(`archivo${tipo}Container`);
            if (container) {
                container.style.display = 'block';
            }
        });
    });
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
