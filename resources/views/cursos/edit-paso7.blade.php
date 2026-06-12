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
        border-radius: 0;
        padding: 12px 35px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .stps-title {
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
                        <h2>Editar Paso 7: Documentación STPS y Certificados</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza trámites oficiales y certificados</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 7]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- General -->
                            <div class="form-section-card shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="FechadeRegistro_STPS" class="form-label">Fecha de Registro STPS</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="FechadeRegistro_STPS" id="FechadeRegistro_STPS" class="form-control" 
                                                value="{{ old('FechadeRegistro_STPS', $curso->fecha_registro_stps) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DC5 & Certificado -->
                            <div class="form-section-card shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Formato_DC5" class="form-label">Formato DC5</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            <input type="text" name="Formato_DC5" id="Formato_DC5" class="form-control" 
                                                value="{{ old('Formato_DC5', $curso->formato_dc5) }}" placeholder="Nombre o referencia">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Formato_DC5_Tienefirma" class="form-label">Formato DC5 - ¿Tiene firma?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <select name="Formato_DC5_Tienefirma" id="Formato_DC5_Tienefirma" class="form-select">
                                                <option value="1" {{ old('Formato_DC5_Tienefirma', $curso->formato_dc5_tiene_firma) ? 'selected' : '' }}>Sí</option>
                                                <option value="0" {{ !old('Formato_DC5_Tienefirma', $curso->formato_dc5_tiene_firma) ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Certificadodecomprobacion" class="form-label">Certificado de Comprobación</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-stamp"></i></span>
                                            <select name="Certificadodecomprobacion" id="Certificadodecomprobacion" class="form-select">
                                                <option value="Ya obtenida" {{ old('Certificadodecomprobacion', $curso->certificado_comprobacion) == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                                                <option value="En proceso" {{ old('Certificadodecomprobacion', $curso->certificado_comprobacion) == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                                <option value="No obtenida" {{ old('Certificadodecomprobacion', $curso->certificado_comprobacion) == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivedeCertificadodecomprobacion" class="form-label">Drive Certificado</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivedeCertificadodecomprobacion" id="DrivedeCertificadodecomprobacion" class="form-control" 
                                                value="{{ old('DrivedeCertificadodecomprobacion', $curso->drive_certificado_comprobacion) }}" placeholder="Enlace de Drive">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carta Poder & UDEMY -->
                            <div class="form-section-card shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Cartapoder_tienefirma" class="form-label">Carta Poder - ¿Tiene firma?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <select name="Cartapoder_tienefirma" id="Cartapoder_tienefirma" class="form-select">
                                                <option value="1" {{ old('Cartapoder_tienefirma', $curso->carta_poder_tiene_firma) ? 'selected' : '' }}>Sí</option>
                                                <option value="0" {{ !old('Cartapoder_tienefirma', $curso->carta_poder_tiene_firma) ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="UDEMY" class="form-label">UDEMY</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                            <select name="UDEMY" id="UDEMY" class="form-select">
                                                <option value="1" {{ old('UDEMY', $curso->udemy) ? 'selected' : '' }}>Prellenado / Sí</option>
                                                <option value="0" {{ !old('UDEMY', $curso->udemy) ? 'selected' : '' }}>No / No se ha prellenado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="DriveCartapoder" class="form-label">Drive Carta Poder</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveCartapoder" id="DriveCartapoder" class="form-control" 
                                                value="{{ old('DriveCartapoder', $curso->drive_carta_poder) }}" placeholder="Enlace de Drive">
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
