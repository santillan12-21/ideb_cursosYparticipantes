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
    .form-select, .form-control {
        border-left: none;
        padding: 10px 15px;
    }
    .form-select:focus, .form-control:focus {
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
                        <h2>Editar Paso 2: Modalidad del Curso</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza cómo se impartirá el curso</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 2]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-section-card shadow-sm">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label for="Virtual" class="form-label">¿El curso es Virtual?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                            <select name="Virtual" id="Virtual" class="form-select @error('Virtual') is-invalid @enderror" required>
                                                <option value="1" {{ old('Virtual', $curso->virtual) ? 'selected' : '' }}>Sí</option>
                                                <option value="0" {{ !old('Virtual', $curso->virtual) ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('Virtual')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="Presencial" class="form-label">¿El curso es Presencial?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            <select name="Presencial" id="Presencial" class="form-select @error('Presencial') is-invalid @enderror" required>
                                                <option value="1" {{ old('Presencial', $curso->presencial) ? 'selected' : '' }}>Sí</option>
                                                <option value="0" {{ !old('Presencial', $curso->presencial) ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('Presencial')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="Mixto" class="form-label">¿El curso es Mixto?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-blender"></i></span>
                                            <select name="Mixto" id="Mixto" class="form-select @error('Mixto') is-invalid @enderror" required>
                                                <option value="1" {{ old('Mixto', $curso->mixto) ? 'selected' : '' }}>Sí</option>
                                                <option value="0" {{ !old('Mixto', $curso->mixto) ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('Mixto')
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