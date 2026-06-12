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
        border-radius: 0;
        padding: 12px 35px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
</style>

<div class="step-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card step-card">
                    <div class="step-header">
                        <h2>Paso 1: Datos del Curso</h2>
                        <p class="mb-0 mt-2 opacity-75">Información básica y general</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('curso.paso1.guardar') }}" method="POST">
                            @csrf
                            <div class="form-section-card shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Nomenclatura" class="form-label">Nomenclatura del Curso</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            <input type="text" name="Nomenclatura" id="Nomenclatura" 
                                                class="form-control @error('Nomenclatura') is-invalid @enderror"
                                                placeholder="Ej: CUR-2024-001" 
                                                value="{{ old('Nomenclatura', session('nomenclatura_generada')) }}" required>
                                            @error('Nomenclatura')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="NombredelCurso" class="form-label">Nombre del Curso</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                                            <input type="text" name="NombredelCurso" id="NombredelCurso"
                                                class="form-control @error('NombredelCurso') is-invalid @enderror" 
                                                placeholder="Ingrese el nombre" 
                                                value="{{ old('NombredelCurso', $curso->NombredelCurso ?? '') }}" required>
                                            @error('NombredelCurso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="DescripciondeCurso" class="form-label">Descripción</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                            <textarea name="DescripciondeCurso" id="DescripciondeCurso" 
                                                class="form-control @error('DescripciondeCurso') is-invalid @enderror" 
                                                rows="3" placeholder="Breve descripción del curso" required>{{ old('DescripciondeCurso', $curso->DescripciondeCurso ?? '') }}</textarea>
                                            @error('DescripciondeCurso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="CostodelCurso" class="form-label">Costo ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="number" step="0.01" name="CostodelCurso" id="CostodelCurso"
                                                class="form-control @error('CostodelCurso') is-invalid @enderror"
                                                value="{{ old('CostodelCurso', $curso->CostodelCurso ?? '') }}"
                                                placeholder="0.00" required>
                                            @error('CostodelCurso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <label for="InstructorResponsable" class="form-label">Instructor Responsable</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <input type="text" name="InstructorResponsable" id="InstructorResponsable"
                                                class="form-control @error('InstructorResponsable') is-invalid @enderror"
                                                placeholder="Nombre del instructor" 
                                                value="{{ old('InstructorResponsable', $curso->InstructorResponsable ?? '') }}" required>
                                            @error('InstructorResponsable')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="FechadeInicio" class="form-label">Fecha de Inicio</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="FechadeInicio" id="FechadeInicio"
                                                class="form-control @error('FechadeInicio') is-invalid @enderror"
                                                value="{{ old('FechadeInicio', $curso->FechadeInicio ?? '') }}" required>
                                            @error('FechadeInicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="FechadeTermino" class="form-label">Fecha de Término</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                            <input type="date" name="FechadeTermino" id="FechadeTermino"
                                                class="form-control @error('FechadeTermino') is-invalid @enderror"
                                                value="{{ old('FechadeTermino', $curso->FechadeTermino ?? '') }}" required>
                                            @error('FechadeTermino')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="Duracioncurso" class="form-label">Duración del Curso</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            <input type="text" name="Duracioncurso" id="Duracioncurso"
                                                class="form-control @error('Duracioncurso') is-invalid @enderror"
                                                placeholder="Ej: 20 horas" 
                                                value="{{ old('Duracioncurso', $curso->Duracioncurso ?? '') }}" required>
                                            @error('Duracioncurso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-dark btn-custom shadow-sm">
                                    <i class="fas fa-save me-2"></i> Guardar y Continuar
                                </button>
                                <a href="{{ route('curso.cancelar') }}" class="btn btn-secondary btn-custom shadow-sm">
                                    <i class="fas fa-times me-2"></i> Cancelar
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
