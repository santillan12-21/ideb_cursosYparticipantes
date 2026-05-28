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
    .material-title {
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
                        <h2>Editar Paso 5: Material de Apoyo</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza recursos digitales e impresos</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 5]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Digital -->
                            <div class="form-section-card shadow-sm">
                                <div class="material-title"><i class="fas fa-file-pdf"></i> Material Digital</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Digital" class="form-label">Digital</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Digital" id="Digital" class="form-control" value="{{ old('Digital', $curso->Digital) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveDigital" class="form-label">Drive Digital</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveDigital" id="DriveDigital" class="form-control" value="{{ old('DriveDigital', $curso->DriveDigital) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="DigitalLocal" class="form-label">Subir archivo</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="DigitalLocal" id="DigitalLocal" class="form-control">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaMaterialdeapoyo)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle me-1"></i> Ruta actual: {{ $rutaLocal->rutaMaterialdeapoyo }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Impreso Presentable -->
                            <div class="form-section-card shadow-sm">
                                <div class="material-title"><i class="fas fa-print"></i> Material Impreso y Presentable</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        @php
                                            use App\Models\Inscripcion;
                                            $cursoId = $curso->id;
                                            $participante = Inscripcion::where('curso_id', $cursoId)->count();
                                        @endphp
                                        <label for="Impreso_Presentable" class="form-label">Porcentaje del material impreso</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            <select name="Impreso_Presentable" id="Impreso_Presentable" class="form-select">
                                                <option value="{{ $curso->Impreso_Presentable }}" selected>{{ $curso->Impreso_Presentable }} (Actual)</option>
                                                @for ($i = 1; $i <= $participante; $i++)
                                                    <option value="{{ $i }}/{{ $participante }}">{{ $i }}/{{ $participante }}</option>
                                                @endfor
                                            </select>
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
