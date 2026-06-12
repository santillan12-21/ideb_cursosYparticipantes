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
        flex-wrap: wrap;
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
                        <h2>Paso 7: Documentación STPS y Certificados</h2>
                        <p class="mb-0 mt-2 opacity-75">Finalización y trámites oficiales</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="alert alert-info text-center shadow-sm mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Atención:</strong> Si ya completaste este paso al crear el curso original, haz clic en <strong>"Finalizar"</strong> sin volver a subir los archivos.
                        </div>

                        <form action="{{ route('curso.guardar-paso7') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-section-card shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="FechadeRegistro_STPS" class="form-label">Fecha de Registro STPS</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="FechadeRegistro_STPS" id="FechadeRegistro_STPS" class="form-control" 
                                                value="{{ old('FechadeRegistro_STPS', $datosPadre->FechadeRegistro_STPS ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Formato DC5 -->
                            <div class="form-section-card shadow-sm">
                                <div class="stps-title"><i class="fas fa-file-contract"></i> Formato DC5</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Formato_DC5" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="Formato_DC5" id="Formato_DC5" class="form-control" 
                                                value="{{ old('Formato_DC5', $datosPadre->Formato_DC5 ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Formato_DC5_Tienefirma" class="form-label">¿Tiene firma?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <select name="Formato_DC5_Tienefirma" id="Formato_DC5_Tienefirma" class="form-select" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Si" {{ old('Formato_DC5_Tienefirma', $datosPadre->Formato_DC5_Tienefirma ?? '') == 'Si' ? 'selected' : '' }}>Sí</option>
                                                <option value="No" {{ old('Formato_DC5_Tienefirma', $datosPadre->Formato_DC5_Tienefirma ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['DC5'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('FormatoDC5')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoFormatoDC5Container" style="display: none;" class="mt-2">
                                                <input type="file" name="FormatoDC5Local" class="form-control"> 
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('FormatoDC5')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoFormatoDC5Container" style="display: none;" class="mt-2">
                                                <input type="file" name="FormatoDC5Local" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Certificado de Comprobación -->
                            <div class="form-section-card shadow-sm">
                                <div class="stps-title"><i class="fas fa-stamp"></i> Certificado de Comprobación</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Certificadodecomprobacion" class="form-label">Estado</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <select name="Certificadodecomprobacion" id="Certificadodecomprobacion" class="form-select" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Ya obtenida" {{ old('Certificadodecomprobacion', $datosPadre->Certificadodecomprobacion ?? '') == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                                                <option value="En proceso" {{ old('Certificadodecomprobacion', $datosPadre->Certificadodecomprobacion ?? '') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                                <option value="No obtenida" {{ old('Certificadodecomprobacion', $datosPadre->Certificadodecomprobacion ?? '') == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivedeCertificadodecomprobacion" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivedeCertificadodecomprobacion" id="DrivedeCertificadodecomprobacion" class="form-control" 
                                                value="{{ old('DrivedeCertificadodecomprobacion', $datosPadre->DrivedeCertificadodecomprobacion ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['CertificadoComprobacion'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CertificadoComprobacion')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoCertificadoComprobacionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CertificadoComprobacionLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CertificadoComprobacion')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoCertificadoComprobacionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CertificadoComprobacionLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Carta Poder -->
                            <div class="form-section-card shadow-sm">
                                <div class="stps-title"><i class="fas fa-file-signature"></i> Carta Poder</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Cartapoder_tienefirma" class="form-label">¿Tiene firma?</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <select name="Cartapoder_tienefirma" id="Cartapoder_tienefirma" class="form-select" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Si" {{ old('Cartapoder_tienefirma', $datosPadre->Cartapoder_tienefirma ?? '') == 'Si' ? 'selected' : '' }}>Sí</option>
                                                <option value="No" {{ old('Cartapoder_tienefirma', $datosPadre->Cartapoder_tienefirma ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveCartapoder" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveCartapoder" id="DriveCartapoder" class="form-control" 
                                                value="{{ old('DriveCartapoder', $datosPadre->DriveCartapoder ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['cartapoder'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CartaPoder')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoCartaPoderContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CartaPoderLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('CartaPoder')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoCartaPoderContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="CartaPoderLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- UDEMY -->
                            <div class="form-section-card shadow-sm">
                                <div class="stps-title"><i class="fas fa-graduation-cap"></i> UDEMY</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="UDEMY" class="form-label">Estado UDEMY</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            <select name="UDEMY" id="UDEMY" class="form-select" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="Prellenado" {{ old('UDEMY', $datosPadre->UDEMY ?? '') == 'Prellenado' ? 'selected' : '' }}>Prellenado</option>
                                                <option value="No se ha prellenado" {{ old('UDEMY', $datosPadre->UDEMY ?? '') == 'No se ha prellenado' ? 'selected' : '' }}>No se ha prellenado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['Udemy'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Udemy')">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar archivo local
                                            </button>
                                            <div id="archivoUdemyContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="UdemyLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Udemy')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoUdemyContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="UdemyLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-dark btn-custom shadow-sm">
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
