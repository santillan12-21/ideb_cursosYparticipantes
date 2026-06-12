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
                        <h2>Paso 6: Documentos de Evaluación</h2>
                        <p class="mb-0 mt-2 opacity-75">Presentación y herramientas de evaluación</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('curso.paso6.guardar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Presentación -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-desktop"></i> Presentación</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Presentación" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Presentación" id="Presentación" class="form-control percent-input" 
                                                value="{{ old('Presentación') ?? ($curso->Presentación ?? ($datosPadre->Presentación ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DrivePresentacion" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DrivePresentacion" id="DrivePresentacion" class="form-control" 
                                                value="{{ old('DrivePresentacion') ?? ($curso->DrivePresentacion ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['presentacion'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Presentacion')">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoPresentacionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="PresentacionLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Presentacion')">
                                                <i class="fas fa-file-upload me-1"></i> Subir archivo local
                                            </button>
                                            <div id="archivoPresentacionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="PresentacionLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación Diagnóstica -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-vial"></i> Evaluación Diagnóstica</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Evaluación_diagnostica" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Evaluación_diagnostica" id="Evaluación_diagnostica" class="form-control percent-input" 
                                                value="{{ old('Evaluación_diagnostica') ?? ($curso->Evaluación_diagnostica ?? ($datosPadre->Evaluación_diagnostica ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveEvaluacionDiagnostica" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveEvaluacionDiagnostica" id="DriveEvaluacionDiagnostica" class="form-control" 
                                                value="{{ old('DriveEvaluacionDiagnostica') ?? ($curso->DriveEvaluacionDiagnostica ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['EvaluacionDiagnosticaLocal'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('EvaluacionDiagnostica')">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoEvaluacionDiagnosticaContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="EvaluacionDiagnosticaLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('EvaluacionDiagnostica')">
                                                <i class="fas fa-file-upload me-1"></i> Subir archivo local
                                            </button>
                                            <div id="archivoEvaluacionDiagnosticaContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="EvaluacionDiagnosticaLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación de Satisfacción -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-smile"></i> Evaluación de Satisfacción</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="EvaluaciondeSatisfacción" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="EvaluaciondeSatisfacción" id="EvaluaciondeSatisfacción" class="form-control percent-input" 
                                                value="{{ old('EvaluaciondeSatisfacción') ?? ($curso->EvaluaciondeSatisfacción ?? ($datosPadre->EvaluaciondeSatisfacción ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveEvaluacionSatisfaccion" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveEvaluacionSatisfaccion" id="DriveEvaluacionSatisfaccion" class="form-control" 
                                                value="{{ old('DriveEvaluacionSatisfaccion') ?? ($curso->DriveEvaluacionSatisfaccion ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['EvaluacionSatisfaccionLocal'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('EvaluacionSatisfaccion')">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoEvaluacionSatisfaccionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="EvaluacionSatisfaccionLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('EvaluacionSatisfaccion')">
                                                <i class="fas fa-file-upload me-1"></i> Subir archivo local
                                            </button>
                                            <div id="archivoEvaluacionSatisfaccionContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="EvaluacionSatisfaccionLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluación Final -->
                            <div class="form-section-card shadow-sm">
                                <div class="eval-title"><i class="fas fa-flag-checkered"></i> Evaluación Final</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="EvaluacionFinal" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="EvaluacionFinal" id="EvaluacionFinal" class="form-control percent-input" 
                                                value="{{ old('EvaluacionFinal') ?? ($curso->EvaluacionFinal ?? ($datosPadre->EvaluacionFinal ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveEvaluacionFinal" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveEvaluacionFinal" id="DriveEvaluacionFinal" class="form-control" 
                                                value="{{ old('DriveEvaluacionFinal') ?? ($curso->DriveEvaluacionFinal ?? '') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local (opcional)</label>
                                        @if ($archivosLocales['EvaluacionFinalLocal'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('EvaluacionFinal')">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoEvaluacionFinalContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="EvaluacionFinalLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('EvaluacionFinal')">
                                                <i class="fas fa-file-upload me-1"></i> Subir archivo local
                                            </button>
                                            <div id="archivoEvaluacionFinalContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="EvaluacionFinalLocal" class="form-control">
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
                                                <option value="" disabled selected>Seleccione el estado del DC3</option>
                                                <option value="Se entrega DC3" {{ old('DC3') == 'Se entrega DC3' ? 'selected' : '' }}>Se entrega DC3</option>
                                                <option value="No se entrega DC3" {{ old('DC3') == 'No se entrega DC3' ? 'selected' : '' }}>No se entrega DC3</option>
                                                <option value="Entrega pendiente de DC3" {{ old('DC3') == 'Entrega pendiente de DC3' ? 'selected' : '' }}>Entrega pendiente de DC3</option>
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
                                    <i class="fas fa-save me-2"></i> Guardar y Continuar
                                </button>
                                <a href="{{ route('curso.paso5') }}" class="btn btn-secondary btn-custom shadow-sm">
                                    <i class="fas fa-arrow-left me-2"></i> Regresar
                                </a>
                                <a href="{{ route('curso.cancelar') }}" class="btn btn-danger btn-custom shadow-sm" onclick="return confirm('¿Estás seguro de que deseas cancelar la creación? Se perderán los datos ingresados.')">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                                <button type="button" class="btn btn-warning btn-custom shadow-sm" id="finalizarForzadoBtn">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Finalización Forzada
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.percent-input').forEach(input => {
        input.addEventListener('blur', function() {
            let val = this.value.trim();
            if (val && !val.includes('%')) {
                if (!isNaN(val)) {
                    this.value = val + '%';
                }
            }
        });
    });

    function crearCarpeta(tipo) {
        fetch('{{ route("crear.carpeta") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ tipo: tipo })
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

    document.getElementById('finalizarForzadoBtn').addEventListener('click', function () {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esto guardará el curso como incompleto y no podrás continuar editándolo.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, finalizar ahora',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(document.querySelector('form'));
                fetch('{{ route("curso.finalizacionForzada") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Curso guardado',
                            text: 'El curso ha sido guardado como incompleto.'
                        }).then(() => { window.location.href = "{{ route('cursos.index') }}"; });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: data.message });
                    }
                });
            }
        });
    });
</script>
@endsection
