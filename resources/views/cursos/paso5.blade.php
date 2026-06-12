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
                        <h2>Paso 5: Material de Apoyo</h2>
                        <p class="mb-0 mt-2 opacity-75">Recursos digitales e impresos</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('curso.paso5.guardar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Digital -->
                            <div class="form-section-card shadow-sm">
                                <div class="material-title"><i class="fas fa-file-pdf"></i> Material Digital</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Digital" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Digital" id="Digital" class="form-control percent-input" 
                                                value="{{ old('Digital', $curso->Digital ?? ($datosPadre->Digital ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveDigital" class="form-label">URL Drive (opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveDigital" id="DriveDigital" class="form-control" 
                                                value="{{ old('DriveDigital') }}" placeholder="https://drive.google.com/...">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local - Digital</label>
                                        @if (!empty($archivosLocales['Materialdeapoyo']) && $archivosLocales['Materialdeapoyo'] === 'actual')
                                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Digital')">
                                                <i class="fas fa-sync-alt me-1"></i> Subir archivo actualizado
                                            </button>
                                            <div id="archivoDigitalContainer" style="display:none;" class="mt-2">
                                                <input type="file" name="DigitalLocal" class="form-control">
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('Digital')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoDigitalContainer" style="display:none;" class="mt-2">
                                                <input type="file" name="DigitalLocal" class="form-control">
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
                                        <label for="Impreso_Presentable" class="form-label">Porcentaje</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Impreso_Presentable" id="Impreso_Presentable" class="form-control percent-input" 
                                                value="{{ old('Impreso_Presentable', $curso->Impreso_Presentable ?? ($datosPadre->Impreso_Presentable ?? '')) }}" placeholder="Ej: 100%">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Archivo Local - Impreso Presentable</label>
                                        @if (!empty($archivosLocales['cursoenlinea']) && $archivosLocales['cursoenlinea'] === 'actual')           
                                            <div class="alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1"></i> Este archivo ya fue subido en el curso original
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="crearCarpeta('ImpresoPresentable')">
                                                <i class="fas fa-folder-plus me-1"></i> Crear carpeta local
                                            </button>
                                            <div id="archivoImpresoPresentableContainer" style="display: none;" class="mt-2">
                                                <input type="file" name="ImpresoPresentableLocal" class="form-control">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="botones-container">
                                <button type="submit" class="btn btn-dark btn-custom shadow-sm">
                                    <i class="fas fa-save me-2"></i> Guardar y Continuar
                                </button>
                                <a href="{{ route('curso.paso4') }}" class="btn btn-secondary btn-custom shadow-sm">
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
        const nombresCarpetas = {
            'Digital': '2- Material de Apoyo (Digital)',
            'ImpresoPresentable': '8- Curso en Linea'
        };
        const nombreCarpeta = nombresCarpetas[tipo];
        if (!nombreCarpeta) return;

        fetch('{{ route("crear.carpeta") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ tipo, nombreCarpeta })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const idMap = { 'Digital': 'archivoDigitalContainer', 'ImpresoPresentable': 'archivoImpresoPresentableContainer' };
                document.getElementById(idMap[tipo]).style.display = 'block';
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
