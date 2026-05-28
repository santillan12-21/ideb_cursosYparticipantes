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
    .doc-title {
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
                        <h2>Paso 4: Documentos del Curso</h2>
                        <p class="mb-0 mt-2 opacity-75">Temario, Itinerario y Planeación</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('curso.paso4.guardar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Temario -->
                            <div class="form-section-card shadow-sm">
                                <div class="doc-title"><i class="fas fa-list-ul"></i> Temario</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Temario" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Temario" id="Temario" class="form-control" 
                                                value="{{ old('Temario') ?? ($curso->Temario ?? ($datosPadre->Temario ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveTemario" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveTemario" id="DriveTemario" class="form-control" 
                                                value="{{ old('DriveTemario') ?? ($curso->DriveTemario ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['Temario'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-create-folder" data-tipo="Temario">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoTemarioContainer" class="mt-2">
                                                <input type="file" name="TemarioLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-create-folder" data-tipo="Temario">
                                                <i class="fas fa-file-upload me-1"></i> Subir archivo local
                                            </button>
                                            <div id="archivoTemarioContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="TemarioLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Itinerario -->
                            <div class="form-section-card shadow-sm">
                                <div class="doc-title"><i class="fas fa-route"></i> Itinerario</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Itinerario" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Itinerario" id="Itinerario" class="form-control" 
                                                value="{{ old('Itinerario') ?? ($curso->Itinerario ?? ($datosPadre->Itinerario ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveItinerario" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveItinerario" id="DriveItinerario" class="form-control" 
                                                value="{{ old('DriveItinerario') ?? ($curso->DriveItinerario ?? ($datosPadre->DriveItinerario ?? '')) }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['Itinerario'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-create-folder" data-tipo="Itinerario">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoItinerarioContainer" class="mt-2">
                                                <input type="file" name="ItinerarioLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-create-folder" data-tipo="Itinerario">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoItinerarioContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="ItinerarioLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Planeación -->
                            <div class="form-section-card shadow-sm">
                                <div class="doc-title"><i class="fas fa-tasks"></i> Planeación</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Planeación" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Planeación" id="Planeación" class="form-control" 
                                                value="{{ old('Planeación') ?? ($curso->Planeación ?? ($datosPadre->Planeación ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivePlaneación" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivePlaneación" id="DrivePlaneación" class="form-control" 
                                                value="{{ old('DrivePlaneación') ?? ($curso->DrivePlaneación ?? ($datosPadre->DrivePlaneación ?? '')) }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['Planeacion'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-create-folder" data-tipo="Planeación">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoPlaneaciónContainer" class="mt-2">
                                                <input type="file" name="PlaneaciónLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-create-folder" data-tipo="Planeación">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoPlaneaciónContainer" class="mt-2">
                                                <input type="file" name="PlaneaciónLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-dark btn-custom shadow-sm">
                                    <i class="fas fa-save me-2"></i> Guardar y Continuar
                                </button>
                                <a href="{{ route('curso.paso3') }}" class="btn btn-secondary btn-custom shadow-sm">
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
    document.querySelectorAll('.btn-create-folder').forEach(btn => {
        btn.addEventListener('click', function() {
            const tipo = btn.getAttribute('data-tipo');
            const container = document.getElementById(`archivo${tipo}Container`);
            if (container) {
                container.style.display = 'block';
            }
        });
    });

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
