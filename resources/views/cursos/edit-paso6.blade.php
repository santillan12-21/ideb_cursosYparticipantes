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
    .form-control, .form-select {
        border-left: none;
        padding: 10px 15px;
    }
    .form-control:focus, .form-select:focus {
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
    .eval-title {
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
                        <h2>Editar Paso 6: Documentos de Evaluación</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza presentación y herramientas de evaluación</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 6]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Presentación -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-desktop"></i> Presentación</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="Presentación" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Presentación" id="Presentación" class="form-control" value="{{ old('Presentación', $curso->Presentación) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="PresentacionLocal" class="form-label">Subir archivo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="PresentacionLocal" id="PresentacionLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutapresentacion)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutapresentacion }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación Diagnóstica -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-vial"></i> Evaluación Diagnóstica</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="Evaluación_diagnostica" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Evaluación_diagnostica" id="Evaluación_diagnostica" class="form-control" value="{{ old('Evaluación_diagnostica', $curso->Evaluación_diagnostica) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="EvaluacionDiagnosticaLocal" class="form-label">Subir archivo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="EvaluacionDiagnosticaLocal" id="EvaluacionDiagnosticaLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaEvaluacionDiagnostica)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaEvaluacionDiagnostica }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación de Satisfacción -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-smile"></i> Evaluación de Satisfacción</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="EvaluaciondeSatisfacción" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="EvaluaciondeSatisfacción" id="EvaluaciondeSatisfacción" class="form-control" value="{{ old('EvaluaciondeSatisfacción', $curso->EvaluaciondeSatisfacción) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="EvaluacionSatisfaccionLocal" class="form-label">Subir archivo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="EvaluacionSatisfaccionLocal" id="EvaluacionSatisfaccionLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaEvaluacionSatisfaccion)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaEvaluacionSatisfaccion }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación Final -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-flag-checkered"></i> Evaluación Final</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="EvaluacionFinal" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="EvaluacionFinal" id="EvaluacionFinal" class="form-control" value="{{ old('EvaluacionFinal', $curso->EvaluacionFinal) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="EvaluacionFinalLocal" class="form-label">Subir archivo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="EvaluacionFinalLocal" id="EvaluacionFinalLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaEvaluacionFinal)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaEvaluacionFinal }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- DC3 -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-certificate"></i> DC3</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="DC3" class="form-label">Estado del DC3</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <select name="DC3" id="DC3" class="form-select @error('DC3') is-invalid @enderror" required>
                                                <option value="" disabled>Seleccione el estado del DC3</option>
                                                <option value="Tiene DC3" {{ old('DC3', $curso->DC3) == 'Tiene DC3' ? 'selected' : '' }}>Tiene DC3</option>
                                                <option value="No tiene DC3" {{ old('DC3', $curso->DC3) == 'No tiene DC3' ? 'selected' : '' }}>No tiene DC3</option>
                                                <option value="Por confirmar" {{ old('DC3', $curso->DC3) == 'Por confirmar' ? 'selected' : '' }}>Por confirmar</option>
                                            </select>
                                            @error('DC3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
