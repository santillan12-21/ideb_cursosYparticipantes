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
                        <h2>Editar Paso 4: Documentos del Curso</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza Temario, Itinerario y Planeación</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 4]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Temario -->
                            <div class="form-section-card shadow-sm">
                                <div class="doc-title"><i class="fas fa-list-ul"></i> Temario</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Temario" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Temario" id="Temario" class="form-control" value="{{ old('Temario', $curso->Temario) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveTemario" class="form-label">Drive Temario</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveTemario" id="DriveTemario" class="form-control" value="{{ old('DriveTemario', $curso->DriveTemario) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="TemarioLocal" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="TemarioLocal" id="TemarioLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaTemario)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaTemario }}
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
                                            <input type="text" name="Itinerario" id="Itinerario" class="form-control" value="{{ old('Itinerario', $curso->Itinerario) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveItinerario" class="form-label">Drive Itinerario</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveItinerario" id="DriveItinerario" class="form-control" value="{{ old('DriveItinerario', $curso->DriveItinerario) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="ItinerarioLocal" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="ItinerarioLocal" id="ItinerarioLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaItinerario)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaItinerario }}
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
                                            <input type="text" name="Planeación" id="Planeación" class="form-control" value="{{ old('Planeación', $curso->Planeación) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivePlaneación" class="form-label">Drive Planeación</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivePlaneación" id="DrivePlaneación" class="form-control" value="{{ old('DrivePlaneación', $curso->DrivePlaneación) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="PlaneaciónLocal" class="form-label">Editar Archivo Local</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="PlaneaciónLocal" id="PlaneaciónLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaPlaneacion)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaPlaneacion }}
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
