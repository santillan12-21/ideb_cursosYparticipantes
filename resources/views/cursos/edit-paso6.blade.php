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
        transition: all 0.3s ease;
        position: relative;
    }
    .form-section-card.completo {
        border-left: 4px solid #28a745;
        background: #f0fff4;
    }
    .form-section-card.incompleto {
        border-left: 4px solid #ffc107;
        background: #fffef0;
    }
    .form-section-card.vacio {
        border-left: 4px solid #dc3545;
        background: #fff5f5;
        animation: pulse-section 2s ease-in-out infinite;
    }
    
    @keyframes pulse-section {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.1); }
        50% { box-shadow: 0 0 20px 5px rgba(220, 53, 69, 0.1); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.1); }
    }
    
    .form-label {
        font-weight: 700;
        color: #495057;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .input-group-text {
        background-color: #ffffff;
        color: #6c757d;
        border-right: none;
    }
    .form-control, .form-select {
        border-left: none;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    
    /* ============================================
       ESTILOS PARA VALIDACIÓN DE CAMPOS
       ============================================ */
    
    .form-control.validado-completo {
        border-color: #28a745 !important;
        background-color: #f0fff4 !important;
        border-left: 4px solid #28a745 !important;
        box-shadow: 0 0 0 1px rgba(40, 167, 69, 0.1);
    }
    
    .form-control.validado-incompleto {
        border-color: #ffc107 !important;
        background-color: #fffef0 !important;
        border-left: 4px solid #ffc107 !important;
        box-shadow: 0 0 0 1px rgba(255, 193, 7, 0.1);
    }
    
    .form-control.validado-vacio {
        border-color: #dc3545 !important;
        background-color: #fff5f5 !important;
        border-left: 4px solid #dc3545 !important;
        box-shadow: 0 0 0 1px rgba(220, 53, 69, 0.1);
        animation: pulse-red 2s ease-in-out infinite;
    }
    
    .form-select.validado-completo {
        border-color: #28a745 !important;
        background-color: #f0fff4 !important;
        border-left: 4px solid #28a745 !important;
    }
    
    .form-select.validado-vacio {
        border-color: #dc3545 !important;
        background-color: #fff5f5 !important;
        border-left: 4px solid #dc3545 !important;
        animation: pulse-red 2s ease-in-out infinite;
    }
    
    .estado-indicador {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        transition: all 0.4s ease;
        flex-shrink: 0;
        border: 2px solid #e9ecef;
    }
    
    .estado-indicador.estado-verde {
        background-color: #28a745;
        border-color: #28a745;
        box-shadow: 0 0 12px rgba(40, 167, 69, 0.4);
    }
    
    .estado-indicador.estado-amarillo {
        background-color: #ffc107;
        border-color: #ffc107;
        box-shadow: 0 0 12px rgba(255, 193, 7, 0.4);
    }
    
    .estado-indicador.estado-rojo {
        background-color: #dc3545;
        border-color: #dc3545;
        box-shadow: 0 0 12px rgba(220, 53, 69, 0.4);
        animation: pulse-red 2s ease-in-out infinite;
    }
    
    @keyframes pulse-red {
        0% { box-shadow: 0 0 12px rgba(220, 53, 69, 0.4); }
        50% { box-shadow: 0 0 25px rgba(220, 53, 69, 0.8); }
        100% { box-shadow: 0 0 12px rgba(220, 53, 69, 0.4); }
    }
    
    #estadoBadge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.5s ease;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
    }
    
    #estadoBadge .estado-indicador {
        width: 16px;
        height: 16px;
        border: none;
    }
    
    .botones-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .btn-custom {
        border-radius: 6px;
        padding: 12px 35px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .btn-guardar-verde {
        background-color: #28a745 !important;
        border: 2px solid #28a745 !important;
        color: #ffffff !important;
    }
    .btn-guardar-verde:hover {
        background-color: #218838 !important;
        border-color: #1e7e34 !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3) !important;
    }
    .btn-guardar-verde i {
        color: #ffffff !important;
    }
    
    .contador-campos {
        text-align: center;
        margin-top: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #495057;
    }
    .contador-campos span {
        font-weight: 700;
    }
    .contador-campos .completos { color: #28a745; }
    .contador-campos .incompletos { color: #ffc107; }
    .contador-campos .vacios { color: #dc3545; }
    
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

    .estado-archivo {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        margin-left: 10px;
    }
    .estado-archivo.subido {
        background: #28a745;
        color: white;
    }
    .estado-archivo.no-subido {
        background: #dc3545;
        color: white;
    }
</style>

<div class="step-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card step-card">
                    <div class="step-header">
                        <h2>Editar Paso 6: Documentos de Evaluación</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza Presentación y herramientas de evaluación</p>
                        
                        <div id="estadoGeneral" class="mt-3">
                            <span id="estadoBadge">
                                <span class="estado-indicador" id="indicadorGeneral"></span>
                                <span id="textoEstado">Verificando campos...</span>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 6]) }}" method="POST" enctype="multipart/form-data" id="formularioCurso">
                            @csrf
                            @method('PUT')
                            
                            <!-- Presentación -->
                            <div class="form-section-card shadow-sm" id="seccion-Presentacion">
                                <div class="eval-title">
                                    <i class="fas fa-desktop"></i> Presentación
                                    <span class="estado-archivo {{ $rutaLocal && $rutaLocal->rutaPresentacion ? 'subido' : 'no-subido' }}" id="estadoArchivo-Presentacion">
                                        {{ $rutaLocal && $rutaLocal->rutaPresentacion ? '✓ Archivo subido' : '✗ Sin archivo' }}
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Presentación" class="form-label">
                                            Porcentaje
                                            <span class="estado-indicador" id="estado-Presentación"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Presentación" id="Presentación" 
                                                class="form-control" 
                                                value="{{ old('Presentación', $curso->Presentación) }}" 
                                                required
                                                oninput="validarPorcentaje(this)"
                                                onchange="validarPorcentaje(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivePresentacion" class="form-label">
                                            Drive Presentación
                                            <span class="estado-indicador" id="estado-DrivePresentacion"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivePresentacion" id="DrivePresentacion" 
                                                class="form-control" 
                                                value="{{ old('DrivePresentacion', $curso->DrivePresentacion) }}" 
                                                required
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="PresentacionLocal" class="form-label">
                                            Editar Archivo Local
                                            <span class="estado-indicador" id="estado-archivoPresentacion"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="PresentacionLocal" id="PresentacionLocal" 
                                                class="form-control"
                                                onchange="validarArchivo(this, 'Presentacion')">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaPresentacion)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1 text-success"></i> Ruta actual: {{ $rutaLocal->rutaPresentacion }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación Diagnóstica -->
                            <div class="form-section-card shadow-sm" id="seccion-EvaluacionDiagnostica">
                                <div class="eval-title">
                                    <i class="fas fa-vial"></i> Evaluación Diagnóstica
                                    <span class="estado-archivo {{ $rutaLocal && $rutaLocal->rutaEvaluacionDiagnostica ? 'subido' : 'no-subido' }}" id="estadoArchivo-EvaluacionDiagnostica">
                                        {{ $rutaLocal && $rutaLocal->rutaEvaluacionDiagnostica ? '✓ Archivo subido' : '✗ Sin archivo' }}
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Evaluación_diagnostica" class="form-label">
                                            Porcentaje
                                            <span class="estado-indicador" id="estado-Evaluación_diagnostica"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Evaluación_diagnostica" id="Evaluación_diagnostica" 
                                                class="form-control" 
                                                value="{{ old('Evaluación_diagnostica', $curso->Evaluación_diagnostica) }}" 
                                                required
                                                oninput="validarPorcentaje(this)"
                                                onchange="validarPorcentaje(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveEvaluacionDiagnostica" class="form-label">
                                            Drive Evaluación Diagnóstica
                                            <span class="estado-indicador" id="estado-DriveEvaluacionDiagnostica"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveEvaluacionDiagnostica" id="DriveEvaluacionDiagnostica" 
                                                class="form-control" 
                                                value="{{ old('DriveEvaluacionDiagnostica', $curso->DriveEvaluacionDiagnostica) }}" 
                                                required
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="EvaluacionDiagnosticaLocal" class="form-label">
                                            Editar Archivo Local
                                            <span class="estado-indicador" id="estado-archivoEvaluacionDiagnostica"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="EvaluacionDiagnosticaLocal" id="EvaluacionDiagnosticaLocal" 
                                                class="form-control"
                                                onchange="validarArchivo(this, 'EvaluacionDiagnostica')">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaEvaluacionDiagnostica)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1 text-success"></i> Ruta actual: {{ $rutaLocal->rutaEvaluacionDiagnostica }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación de Satisfacción -->
                            <div class="form-section-card shadow-sm" id="seccion-EvaluacionSatisfaccion">
                                <div class="eval-title">
                                    <i class="fas fa-smile"></i> Evaluación de Satisfacción
                                    <span class="estado-archivo {{ $rutaLocal && $rutaLocal->rutaEvaluacionSatisfaccion ? 'subido' : 'no-subido' }}" id="estadoArchivo-EvaluacionSatisfaccion">
                                        {{ $rutaLocal && $rutaLocal->rutaEvaluacionSatisfaccion ? '✓ Archivo subido' : '✗ Sin archivo' }}
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="EvaluaciondeSatisfacción" class="form-label">
                                            Porcentaje
                                            <span class="estado-indicador" id="estado-EvaluaciondeSatisfacción"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="EvaluaciondeSatisfacción" id="EvaluaciondeSatisfacción" 
                                                class="form-control" 
                                                value="{{ old('EvaluaciondeSatisfacción', $curso->EvaluaciondeSatisfacción) }}" 
                                                required
                                                oninput="validarPorcentaje(this)"
                                                onchange="validarPorcentaje(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveEvaluacionSatisfaccion" class="form-label">
                                            Drive Evaluación Satisfacción
                                            <span class="estado-indicador" id="estado-DriveEvaluacionSatisfaccion"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveEvaluacionSatisfaccion" id="DriveEvaluacionSatisfaccion" 
                                                class="form-control" 
                                                value="{{ old('DriveEvaluacionSatisfaccion', $curso->DriveEvaluacionSatisfaccion) }}" 
                                                required
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="EvaluacionSatisfaccionLocal" class="form-label">
                                            Editar Archivo Local
                                            <span class="estado-indicador" id="estado-archivoEvaluacionSatisfaccion"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="EvaluacionSatisfaccionLocal" id="EvaluacionSatisfaccionLocal" 
                                                class="form-control"
                                                onchange="validarArchivo(this, 'EvaluacionSatisfaccion')">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaEvaluacionSatisfaccion)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1 text-success"></i> Ruta actual: {{ $rutaLocal->rutaEvaluacionSatisfaccion }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación Final -->
                            <div class="form-section-card shadow-sm" id="seccion-EvaluacionFinal">
                                <div class="eval-title">
                                    <i class="fas fa-flag-checkered"></i> Evaluación Final
                                    <span class="estado-archivo {{ $rutaLocal && $rutaLocal->rutaEvaluacionFinal ? 'subido' : 'no-subido' }}" id="estadoArchivo-EvaluacionFinal">
                                        {{ $rutaLocal && $rutaLocal->rutaEvaluacionFinal ? '✓ Archivo subido' : '✗ Sin archivo' }}
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="EvaluacionFinal" class="form-label">
                                            Porcentaje
                                            <span class="estado-indicador" id="estado-EvaluacionFinal"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="EvaluacionFinal" id="EvaluacionFinal" 
                                                class="form-control" 
                                                value="{{ old('EvaluacionFinal', $curso->EvaluacionFinal) }}" 
                                                required
                                                oninput="validarPorcentaje(this)"
                                                onchange="validarPorcentaje(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveEvaluacionFinal" class="form-label">
                                            Drive Evaluación Final
                                            <span class="estado-indicador" id="estado-DriveEvaluacionFinal"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveEvaluacionFinal" id="DriveEvaluacionFinal" 
                                                class="form-control" 
                                                value="{{ old('DriveEvaluacionFinal', $curso->DriveEvaluacionFinal) }}" 
                                                required
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="EvaluacionFinalLocal" class="form-label">
                                            Editar Archivo Local
                                            <span class="estado-indicador" id="estado-archivoEvaluacionFinal"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="EvaluacionFinalLocal" id="EvaluacionFinalLocal" 
                                                class="form-control"
                                                onchange="validarArchivo(this, 'EvaluacionFinal')">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaEvaluacionFinal)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1 text-success"></i> Ruta actual: {{ $rutaLocal->rutaEvaluacionFinal }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- DC3 -->
                            <div class="form-section-card shadow-sm" id="seccion-DC3">
                                <div class="eval-title"><i class="fas fa-certificate"></i> DC3</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="DC3" class="form-label">
                                            Estado del DC3
                                            <span class="estado-indicador" id="estado-DC3"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <select name="DC3" id="DC3" 
                                                class="form-select @error('DC3') is-invalid @enderror" 
                                                required
                                                onchange="validarSelect(this)">
                                                <option value="" disabled>Seleccione el estado del DC3</option>
                                                <option value="Se entrega DC3" {{ old('DC3', $curso->DC3) == 'Se entrega DC3' ? 'selected' : '' }}>Se entrega DC3</option>
                                                <option value="No se entrega DC3" {{ old('DC3', $curso->DC3) == 'No se entrega DC3' ? 'selected' : '' }}>No se entrega DC3</option>
                                                <option value="Entrega pendiente de DC3" {{ old('DC3', $curso->DC3) == 'Entrega pendiente de DC3' ? 'selected' : '' }}>Entrega pendiente de DC3</option>
                                            </select>
                                            @error('DC3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="contador-campos">
                                <span class="completos" id="totalCompletos">0</span> completos | 
                                <span class="incompletos" id="totalIncompletos">0</span> incompletos | 
                                <span class="vacios" id="totalVacios">0</span> vacíos
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-guardar-verde btn-custom shadow-sm">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const campos = document.querySelectorAll('#formularioCurso .form-control, #formularioCurso .form-select');
    
    campos.forEach(campo => {
        if (campo.id === 'Presentación' || campo.id === 'Evaluación_diagnostica' || 
            campo.id === 'EvaluaciondeSatisfacción' || campo.id === 'EvaluacionFinal') {
            validarPorcentaje(campo);
        } else if (campo.tagName === 'SELECT') {
            validarSelect(campo);
        } else {
            validarCampo(campo);
        }
    });
    
    // Validar archivos existentes
    const secciones = ['Presentacion', 'EvaluacionDiagnostica', 'EvaluacionSatisfaccion', 'EvaluacionFinal'];
    secciones.forEach(seccion => {
        const rutaActual = document.querySelector('#seccion-' + seccion + ' .alert-success');
        const indicador = document.getElementById('estado-archivo' + seccion);
        if (rutaActual) {
            if (indicador) indicador.className = 'estado-indicador estado-verde';
        } else {
            if (indicador) indicador.className = 'estado-indicador estado-rojo';
        }
    });
    
    actualizarEstadoGeneral();
});

function validarPorcentaje(campo) {
    const valor = campo.value.trim();
    const indicador = document.getElementById('estado-' + campo.id);
    
    campo.classList.remove('validado-completo', 'validado-incompleto', 'validado-vacio');
    if (indicador) {
        indicador.classList.remove('estado-verde', 'estado-amarillo', 'estado-rojo');
    }
    
    if (valor === '') {
        campo.classList.add('validado-vacio');
        if (indicador) {
            indicador.classList.add('estado-rojo');
            indicador.title = 'Campo vacío - Requiere 100%';
        }
    } else if (valor === '100%' || valor === '100 %' || valor === '100') {
        campo.classList.add('validado-completo');
        if (indicador) {
            indicador.classList.add('estado-verde');
            indicador.title = '✅ 100% completo';
        }
    } else {
        campo.classList.add('validado-incompleto');
        if (indicador) {
            indicador.classList.add('estado-amarillo');
            indicador.title = '⚠️ Debe ser 100%';
        }
    }
    
    actualizarSeccion(campo);
    actualizarContadores();
    actualizarEstadoGeneral();
}

function validarCampo(campo) {
    const valor = campo.value.trim();
    const indicador = document.getElementById('estado-' + campo.id);
    
    campo.classList.remove('validado-completo', 'validado-incompleto', 'validado-vacio');
    if (indicador) {
        indicador.classList.remove('estado-verde', 'estado-amarillo', 'estado-rojo');
    }
    
    if (valor === '') {
        campo.classList.add('validado-vacio');
        if (indicador) indicador.classList.add('estado-rojo');
    } else if (valor.length < 3) {
        campo.classList.add('validado-incompleto');
        if (indicador) indicador.classList.add('estado-amarillo');
    } else {
        campo.classList.add('validado-completo');
        if (indicador) indicador.classList.add('estado-verde');
    }
    
    actualizarSeccion(campo);
    actualizarContadores();
    actualizarEstadoGeneral();
}

function validarSelect(select) {
    const valor = select.value;
    const indicador = document.getElementById('estado-' + select.id);
    
    select.classList.remove('validado-completo', 'validado-vacio');
    if (indicador) {
        indicador.classList.remove('estado-verde', 'estado-rojo');
    }
    
    if (valor === '' || valor === null) {
        select.classList.add('validado-vacio');
        if (indicador) indicador.classList.add('estado-rojo');
    } else {
        select.classList.add('validado-completo');
        if (indicador) indicador.classList.add('estado-verde');
    }
    
    actualizarSeccion(select);
    actualizarContadores();
    actualizarEstadoGeneral();
}

function validarArchivo(input, seccion) {
    const indicador = document.getElementById('estado-archivo' + seccion);
    const estadoArchivo = document.getElementById('estadoArchivo-' + seccion);
    
    if (input.files && input.files.length > 0) {
        if (indicador) indicador.className = 'estado-indicador estado-verde';
        if (estadoArchivo) {
            estadoArchivo.className = 'estado-archivo subido';
            estadoArchivo.textContent = '✓ Nuevo archivo seleccionado';
        }
    } else {
        const rutaActual = document.querySelector('#seccion-' + seccion + ' .alert-success');
        if (rutaActual) {
            if (indicador) indicador.className = 'estado-indicador estado-verde';
            if (estadoArchivo) {
                estadoArchivo.className = 'estado-archivo subido';
                estadoArchivo.textContent = '✓ Archivo subido';
            }
        } else {
            if (indicador) indicador.className = 'estado-indicador estado-rojo';
            if (estadoArchivo) {
                estadoArchivo.className = 'estado-archivo no-subido';
                estadoArchivo.textContent = '✗ Sin archivo';
            }
        }
    }
    
    actualizarSeccion(null);
    actualizarContadores();
    actualizarEstadoGeneral();
}

function actualizarSeccion(campo) {
    const secciones = ['Presentacion', 'EvaluacionDiagnostica', 'EvaluacionSatisfaccion', 'EvaluacionFinal', 'DC3'];
    
    secciones.forEach(seccion => {
        const seccionCard = document.getElementById('seccion-' + seccion);
        if (!seccionCard) return;
        
        const camposSeccion = seccionCard.querySelectorAll('.form-control, .form-select');
        let completos = 0, incompletos = 0, vacios = 0;
        
        camposSeccion.forEach(campo => {
            if (campo.classList.contains('validado-completo')) completos++;
            else if (campo.classList.contains('validado-incompleto')) incompletos++;
            else if (campo.classList.contains('validado-vacio')) vacios++;
        });
        
        seccionCard.classList.remove('completo', 'incompleto', 'vacio');
        
        if (vacios > 0 && completos === 0 && incompletos === 0) {
            seccionCard.classList.add('vacio');
        } else if (incompletos > 0) {
            seccionCard.classList.add('incompleto');
        } else if (completos > 0 && vacios === 0 && incompletos === 0) {
            seccionCard.classList.add('completo');
        } else if (completos > 0 && vacios > 0) {
            seccionCard.classList.add('incompleto');
        }
    });
}

function actualizarContadores() {
    const campos = document.querySelectorAll('#formularioCurso .form-control, #formularioCurso .form-select');
    let completos = 0, incompletos = 0, vacios = 0;
    
    campos.forEach(campo => {
        if (campo.classList.contains('validado-completo')) completos++;
        else if (campo.classList.contains('validado-incompleto')) incompletos++;
        else if (campo.classList.contains('validado-vacio')) vacios++;
    });
    
    document.getElementById('totalCompletos').textContent = completos;
    document.getElementById('totalIncompletos').textContent = incompletos;
    document.getElementById('totalVacios').textContent = vacios;
}

function actualizarEstadoGeneral() {
    const campos = document.querySelectorAll('#formularioCurso .form-control, #formularioCurso .form-select');
    let completos = 0, incompletos = 0, vacios = 0;
    const total = campos.length;
    
    campos.forEach(campo => {
        if (campo.classList.contains('validado-completo')) completos++;
        else if (campo.classList.contains('validado-incompleto')) incompletos++;
        else if (campo.classList.contains('validado-vacio')) vacios++;
    });
    
    const indicadorGeneral = document.getElementById('indicadorGeneral');
    const textoEstado = document.getElementById('textoEstado');
    
    if (vacios > 0) {
        indicadorGeneral.className = 'estado-indicador estado-rojo';
        textoEstado.textContent = `⚠️ ${vacios} campo(s) vacío(s) - Requiere atención`;
    } else if (incompletos > 0) {
        indicadorGeneral.className = 'estado-indicador estado-amarillo';
        textoEstado.textContent = `🟡 ${incompletos} campo(s) incompleto(s) - Deben ser 100%`;
    } else if (completos === total) {
        indicadorGeneral.className = 'estado-indicador estado-verde';
        textoEstado.textContent = '✅ Todos los campos completos - Listo para guardar';
    } else {
        indicadorGeneral.className = 'estado-indicador';
        textoEstado.textContent = 'Verificando campos...';
    }
}
</script>
@endsection