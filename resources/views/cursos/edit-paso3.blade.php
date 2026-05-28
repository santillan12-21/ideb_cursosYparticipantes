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
                        <h2>Editar Paso 3: Formato de Flyer / Imagen</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza material gráfico y redes sociales</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 3]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Sin Fecha -->
                            <div class="form-section-card shadow-sm">
                                <div class="platform-title"><i class="fas fa-calendar-times"></i> Sin Fecha</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="SinFecha" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="SinFecha" id="SinFecha" class="form-control" value="{{ old('SinFecha', $curso->SinFecha) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveSinFecha" class="form-label">Drive Sin Fecha</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveSinFecha" id="DriveSinFecha" class="form-control" value="{{ old('DriveSinFecha', $curso->DriveSinFecha) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoSinFecha" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="archivoSinFecha" id="archivoSinFecha" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaSinFecha)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaSinFecha }}
                                            </div>
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
                                            <input type="text" name="Facebook" id="Facebook" class="form-control" value="{{ old('Facebook', $curso->Facebook) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveFacebook" class="form-label">Drive Facebook</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveFacebook" id="DriveFacebook" class="form-control" value="{{ old('DriveFacebook', $curso->DriveFacebook) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoFacebook" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="archivoFacebook" id="archivoFacebook" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaFacebook)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaFacebook }}
                                            </div>
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
                                            <input type="text" name="Linkedin" id="Linkedin" class="form-control" value="{{ old('Linkedin', $curso->Linkedin) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveLinkedin" class="form-label">Drive LinkedIn</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveLinkedin" id="DriveLinkedin" class="form-control" value="{{ old('DriveLinkedin', $curso->DriveLinkedin) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoLinkedIn" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="archivoLinkedIn" id="archivoLinkedIn" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaLinkedIn)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaLinkedIn }}
                                            </div>
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
                                            <input type="text" name="Instagram" id="Instagram" class="form-control" value="{{ old('Instagram', $curso->Instagram) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveInstagram" class="form-label">Drive Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveInstagram" id="DriveInstagram" class="form-control" value="{{ old('DriveInstagram', $curso->DriveInstagram) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoInstagram" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="archivoInstagram" id="archivoInstagram" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaInstagram)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaInstagram }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-dark btn-custom shadow-sm">
                                    <i class="fas fa-save me-2"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary btn-custom shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Regresar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
