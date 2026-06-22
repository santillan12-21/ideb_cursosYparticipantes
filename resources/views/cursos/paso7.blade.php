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
    
    .btn-finalizar-verde {
        background-color: #28a745 !important;
        border: 2px solid #28a745 !important;
        color: #ffffff !important;
    }
    .btn-finalizar-verde:hover {
        background-color: #218838 !important;
        border-color: #1e7e34 !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3) !important;
    }
    .btn-finalizar-verde i {
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
                        <h2>Paso 7: Documentación STPS y Certificados</h2>
                        <p class="mb-0 mt-2 opacity-75">Finalización y trámites oficiales</p>
                        
                        <div id="estadoGeneral" class="mt-3">
                            <span id="estadoBadge">
                                <span class="estado-indicador" id="indicadorGeneral"></span>
                                <span id="textoEstado">Verificando campos...</span>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="alert alert-info text-center shadow-sm mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Atención:</strong> Si ya completaste este paso al crear el curso original, haz clic en <strong>"Finalizar"</strong> sin volver a subir los archivos.
                        </div>

                        <form action="{{ route('curso.guardar-paso7') }}" method="POST" enctype="multipart/form-data" id="formularioCurso">
                            @csrf
                            
                            <!-- Fecha Registro STPS -->
                            <div class="form-section-card shadow-sm" id="seccion-FechaSTPS">
                                <div class="stps-title"><i class="fas fa-calendar-alt"></i> Fecha de Registro STPS</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="FechadeRegistro_STPS" class="form-label">
                                            Fecha de Registro STPS
                                            <span class="estado-indicador" id="estado-FechadeRegistro_STPS"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="FechadeRegistro_STPS" id="FechadeRegistro_STPS" 
                                                class="form-control" 
                                                value="{{ old('FechadeRegistro_STPS', $datosPadre->FechadeRegistro_STPS ?? '') }}"
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Formato DC5 -->
                            <div class="form-section-card shadow-sm" id="seccion-FormatoDC5">
                                <div class="stps-title">
                                    <i class="fas fa-file-contract"></i> Formato DC5
                                    <span class="estado-archivo no-subido" id="estadoArchivo-FormatoDC5">
                                        ✗ Sin archivo
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Formato_DC5" class="form-label">
                                            URL Drive (opcional)
                                            <span class="estado-indicador" id="estado-Formato_DC5"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="Formato_DC5" id="Formato_DC5" 
                                                class="form-control" 
                                                value="{{ old('Formato_DC5', $datosPadre->Formato_DC5 ?? '') }}" 
                                                placeholder="https://drive.google.com/..."
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Formato_DC5_Tienefirma" class="form-label">
                                            ¿Tiene firma?
                                            <span class="estado-indicador" id="estado-Formato_DC5_Tienefirma"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <select name="Formato_DC5_Tienefirma" id="Formato_DC5_Tienefirma" 
                                                class="form-select" 
                                                required
                                                onchange="validarSelect(this)">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Si" {{ old('Formato_DC5_Tienefirma', $datosPadre->Formato_DC5_Tienefirma ?? '') == 'Si' ? 'selected' : '' }}>Sí</option>
                                                <option value="No" {{ old('Formato_DC5_Tienefirma', $datosPadre->Formato_DC5_Tienefirma ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoFormatoDC5" class="form-label">
                                            Archivo Local (opcional)
                                            <span class="estado-indicador" id="estado-archivoFormatoDC5"></span>
                                        </label>
                                        @if ($archivosLocales['DC5'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('FormatoDC5')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoFormatoDC5Container" style="display: none;" class="mt-2">
                                                <input type="file" name="FormatoDC5Local" class="form-control" onchange="validarArchivo(this, 'FormatoDC5')">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('FormatoDC5')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoFormatoDC5Container" style="display: none;" class="mt-2">
                                                <input type="file" name="FormatoDC5Local" class="form-control" onchange="validarArchivo(this, 'FormatoDC5')">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Certificado de Comprobación -->
                            <div class="form-section-card shadow-sm" id="seccion-CertificadoComprobacion">
                                <div class="stps-title">
                                    <i class="fas fa-stamp"></i> Certificado de Comprobación
                                    <span class="estado-archivo no-subido" id="estadoArchivo-CertificadoComprobacion">
                                        ✗ Sin archivo
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Certificadodecomprobacion" class="form-label">
                                            Estado
                                            <span class="estado-indicador" id="estado-Certificadodecomprobacion"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <select name="Certificadodecomprobacion" id="Certificadodecomprobacion" 
                                                class="form-select" 
                                                required
                                                onchange="validarSelect(this)">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Ya obtenida" {{ old('Certificadodecomprobacion', $datosPadre->Certificadodecomprobacion ?? '') == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                                                <option value="En proceso" {{ old('Certificadodecomprobacion', $datosPadre->Certificadodecomprobacion ?? '') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                                <option value="No obtenida" {{ old('Certificadodecomprobacion', $datosPadre->Certificadodecomprobacion ?? '') == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivedeCertificadodecomprobacion" class="form-label">
                                            URL Drive (opcional)
                                            <span class="estado-indicador" id="estado-DrivedeCertificadodecomprobacion"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivedeCertificadodecomprobacion" id="DrivedeCertificadodecomprobacion" 
                                                class="form-control" 
                                                value="{{ old('DrivedeCertificadodecomprobacion', $datosPadre->DrivedeCertificadodecomprobacion ?? '') }}" 
                                                placeholder="https://drive.google.com/..."
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoCertificadoComprobacion" class="form-label">
                                            Archivo Local (opcional)
                                            <span class="estado-indicador" id="estado-archivoCertificadoComprobacion"></span>
                                        </label>
                                        @if ($archivosLocales['CertificadoComprobacion'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CertificadoComprobacion')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoCertificadoComprobacionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CertificadoComprobacionLocal" class="form-control" onchange="validarArchivo(this, 'CertificadoComprobacion')">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CertificadoComprobacion')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoCertificadoComprobacionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CertificadoComprobacionLocal" class="form-control" onchange="validarArchivo(this, 'CertificadoComprobacion')">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Carta Poder -->
                            <div class="form-section-card shadow-sm" id="seccion-CartaPoder">
                                <div class="stps-title">
                                    <i class="fas fa-file-signature"></i> Carta Poder
                                    <span class="estado-archivo no-subido" id="estadoArchivo-CartaPoder">
                                        ✗ Sin archivo
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Cartapoder_tienefirma" class="form-label">
                                            ¿Tiene firma?
                                            <span class="estado-indicador" id="estado-Cartapoder_tienefirma"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <select name="Cartapoder_tienefirma" id="Cartapoder_tienefirma" 
                                                class="form-select" 
                                                required
                                                onchange="validarSelect(this)">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Si" {{ old('Cartapoder_tienefirma', $datosPadre->Cartapoder_tienefirma ?? '') == 'Si' ? 'selected' : '' }}>Sí</option>
                                                <option value="No" {{ old('Cartapoder_tienefirma', $datosPadre->Cartapoder_tienefirma ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveCartapoder" class="form-label">
                                            URL Drive (opcional)
                                            <span class="estado-indicador" id="estado-DriveCartapoder"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveCartapoder" id="DriveCartapoder" 
                                                class="form-control" 
                                                value="{{ old('DriveCartapoder', $datosPadre->DriveCartapoder ?? '') }}" 
                                                placeholder="https://drive.google.com/..."
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoCartaPoder" class="form-label">
                                            Archivo Local (opcional)
                                            <span class="estado-indicador" id="estado-archivoCartaPoder"></span>
                                        </label>
                                        @if ($archivosLocales['cartapoder'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CartaPoder')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoCartaPoderContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CartaPoderLocal" class="form-control" onchange="validarArchivo(this, 'CartaPoder')">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CartaPoder')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoCartaPoderContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CartaPoderLocal" class="form-control" onchange="validarArchivo(this, 'CartaPoder')">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- UDEMY -->
                            <div class="form-section-card shadow-sm" id="seccion-Udemy">
                                <div class="stps-title">
                                    <i class="fas fa-graduation-cap"></i> UDEMY
                                    <span class="estado-archivo no-subido" id="estadoArchivo-Udemy">
                                        ✗ Sin archivo
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="UDEMY" class="form-label">
                                            Estado UDEMY
                                            <span class="estado-indicador" id="estado-UDEMY"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <select name="UDEMY" id="UDEMY" 
                                                class="form-select" 
                                                required
                                                onchange="validarSelect(this)">
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Prellenado" {{ old('UDEMY', $datosPadre->UDEMY ?? '') == 'Prellenado' ? 'selected' : '' }}>Prellenado</option>
                                                <option value="No se ha prellenado" {{ old('UDEMY', $datosPadre->UDEMY ?? '') == 'No se ha prellenado' ? 'selected' : '' }}>No se ha prellenado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="archivoUdemy" class="form-label">
                                            Archivo Local (opcional)
                                            <span class="estado-indicador" id="estado-archivoUdemy"></span>
                                        </label>
                                        @if ($archivosLocales['Udemy'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Udemy')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoUdemyContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="UdemyLocal" class="form-control" onchange="validarArchivo(this, 'Udemy')">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Udemy')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoUdemyContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="UdemyLocal" class="form-control" onchange="validarArchivo(this, 'Udemy')">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="contador-campos">
                                <span class="completos" id="totalCompletos">0</span> completos | 
                                <span class="incompletos" id="totalIncompletos">0</span> incompletos | 
                                <span class="vacios" id="totalVacios">0</span> vacíos
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-finalizar-verde btn-custom shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i> Finalizar
                                </button>
                                <a href="{{ route('curso.paso6') }}" class="btn btn-secondary btn-custom shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Regresar
                                </a>
                                <a href="{{ route('curso.cancelar') }}" class="btn btn-danger btn-custom shadow-sm" onclick="return confirm('¿Estás seguro de que deseas cancelar la creación? Se perderán los datos ingresados.')">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const campos = document.querySelectorAll('#formularioCurso .form-control, #formularioCurso .form-select');
    
    campos.forEach(campo => {
        if (campo.tagName === 'SELECT') {
            validarSelect(campo);
        } else {
            validarCampo(campo);
        }
    });
    
    // Validar archivos existentes
    const secciones = ['FormatoDC5', 'CertificadoComprobacion', 'CartaPoder', 'Udemy'];
    secciones.forEach(seccion => {
        const alertExistente = document.querySelector('#seccion-' + seccion + ' .alert-success');
        const indicador = document.getElementById('estado-archivo' + seccion);
        const estadoArchivo = document.getElementById('estadoArchivo-' + seccion);
        
        if (alertExistente) {
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
    });
    
    actualizarEstadoGeneral();
});

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
        const alertExistente = document.querySelector('#seccion-' + seccion + ' .alert-success');
        if (alertExistente) {
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
    const secciones = ['FechaSTPS', 'FormatoDC5', 'CertificadoComprobacion', 'CartaPoder', 'Udemy'];
    
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
        textoEstado.textContent = `🟡 ${incompletos} campo(s) incompleto(s) - Revisar`;
    } else if (completos === total) {
        indicadorGeneral.className = 'estado-indicador estado-verde';
        textoEstado.textContent = '✅ Todos los campos completos - Listo para finalizar';
    } else {
        indicadorGeneral.className = 'estado-indicador';
        textoEstado.textContent = 'Verificando campos...';
    }
}

function crearCarpeta(tipo) {
    fetch('{{ route("crear.carpeta") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ tipo: tipo, nombreCarpeta: tipo })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const contenedor = document.getElementById(`archivo${tipo}Container`);
            if (contenedor) contenedor.style.display = 'block';
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>
@endsection