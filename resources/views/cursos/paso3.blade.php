@extends('layouts.app')

@section('content')
<style>
    .step-container {
        padding: 50px 0;
        background-color: #f4f7f6;
        min-height: calc(100vh - 80px);
    }
    .step-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        background: white;
    }
    .step-header {
        background: linear-gradient(135deg, #000000 0%, #333333 100%);
        padding: 30px;
        color: white;
        text-align: center;
    }
    .step-header h2 {
        font-weight: 300;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0;
    }
    .form-section-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid #e9ecef;
    }
    .form-label {
        font-weight: 700;
        color: #495057;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .input-group-text {
        background-color: #ffffff;
        color: #6c757d;
        border-right: none;
    }
    .form-control {
        border-left: none;
        padding: 10px 15px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    .botones-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .btn-custom {
        border-radius: 30px;
        padding: 12px 35px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .platform-title {
        font-weight: 700;
        text-transform: uppercase;
        color: #333;
        border-bottom: 2px solid #333;
        padding-bottom: 5px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="step-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card step-card">
                    <div class="step-header">
                        <h2>Paso 3: Formato de Flyer / Imagen</h2>
                        <p class="mb-0 mt-2 opacity-75">Material gráfico y redes sociales</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('curso.paso3.guardar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Sin Fecha -->
                            <div class="form-section-card shadow-sm">
                                <div class="platform-title"><i class="fas fa-calendar-times"></i> Sin Fecha</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="SinFecha" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="SinFecha" id="SinFecha" class="form-control" value="{{ old('SinFecha') }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveSinFecha" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveSinFecha" id="DriveSinFecha" class="form-control" value="{{ old('DriveSinFecha') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpetasLocales()">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoSinFechaContainer" style="display: {{ isset($carpetasExistentes['SinFecha']) && $carpetasExistentes['SinFecha'] ? 'block' : 'none' }}; flex-grow: 1;">
                                                <input type="file" name="SinFechaLocal" class="form-control">
                                            </div>
                                        </div>
                                        @if(session('cursos_paso3.SinFechaLocal'))
                                            <small class="text-success mt-1 d-block"><i class="fas fa-check-circle"></i> Archivo subido: {{ session('cursos_paso3.SinFechaLocal') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Facebook -->
                            <div class="form-section-card shadow-sm">
                                <div class="platform-title"><i class="fab fa-facebook"></i> Facebook</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Facebook" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Facebook" id="Facebook" class="form-control" value="{{ old('Facebook') }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveFacebook" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveFacebook" id="DriveFacebook" class="form-control" value="{{ old('DriveFacebook') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpetasLocales()">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoFacebookContainer" style="display: {{ isset($carpetasExistentes['Facebook']) && $carpetasExistentes['Facebook'] ? 'block' : 'none' }}; flex-grow: 1;">
                                                <input type="file" name="FacebookLocal" class="form-control">
                                            </div>
                                        </div>
                                        @if(session('cursos_paso3.FacebookLocal'))
                                            <small class="text-success mt-1 d-block"><i class="fas fa-check-circle"></i> Archivo subido: {{ session('cursos_paso3.FacebookLocal') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- LinkedIn -->
                            <div class="form-section-card shadow-sm">
                                <div class="platform-title"><i class="fab fa-linkedin"></i> LinkedIn</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Linkedin" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Linkedin" id="Linkedin" class="form-control" value="{{ old('Linkedin') }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveLinkedin" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveLinkedin" id="DriveLinkedin" class="form-control" value="{{ old('DriveLinkedin') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpetasLocales()">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoLinkedInContainer" style="display: {{ isset($carpetasExistentes['LinkedIn']) && $carpetasExistentes['LinkedIn'] ? 'block' : 'none' }}; flex-grow: 1;">
                                                <input type="file" name="LinkedInLocal" class="form-control">
                                            </div>
                                        </div>
                                        @if(session('cursos_paso3.LinkedInLocal'))
                                            <small class="text-success mt-1 d-block"><i class="fas fa-check-circle"></i> Archivo subido: {{ session('cursos_paso3.LinkedInLocal') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div class="form-section-card shadow-sm">
                                <div class="platform-title"><i class="fab fa-instagram"></i> Instagram</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Instagram" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Instagram" id="Instagram" class="form-control" value="{{ old('Instagram') }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveInstagram" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveInstagram" id="DriveInstagram" class="form-control" value="{{ old('DriveInstagram') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpetasLocales()">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoInstagramContainer" style="display: {{ isset($carpetasExistentes['Instagram']) && $carpetasExistentes['Instagram'] ? 'block' : 'none' }}; flex-grow: 1;">
                                                <input type="file" name="InstagramLocal" class="form-control">
                                            </div>
                                        </div>
                                        @if(session('cursos_paso3.InstagramLocal'))
                                            <small class="text-success mt-1 d-block"><i class="fas fa-check-circle"></i> Archivo subido: {{ session('cursos_paso3.InstagramLocal') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-dark btn-custom shadow-sm">
                                    <i class="fas fa-save me-2"></i> Guardar y Continuar
                                </button>
                                <a href="{{ route('curso.paso2') }}" class="btn btn-secondary btn-custom shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Regresar
                                </a>
                                <button type="button" class="btn btn-warning btn-custom shadow-sm" id="finalizarForzadoBtn">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Finalización Forzada
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    document.querySelector(`#archivo${tipo}Container`).style.display = 'block';
                }
            });
        });
    }

    document.getElementById('finalizarForzadoBtn').addEventListener('click', function () {
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
                const formData = new FormData(document.querySelector('form'));
                fetch('{{ route("curso.finalizacionForzada") }}', {
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
@endsection
