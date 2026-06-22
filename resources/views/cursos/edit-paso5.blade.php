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
                        <h2>Editar Paso 5: Material de Apoyo</h2>
                        <p class="mb-0 mt-2 opacity-75">Actualiza recursos digitales e impresos</p>
                        
                        <div id="estadoGeneral" class="mt-3">
                            <span id="estadoBadge">
                                <span class="estado-indicador" id="indicadorGeneral"></span>
                                <span id="textoEstado">Verificando campos...</span>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('cursos.update.paso', [$curso->id, 5]) }}" method="POST" enctype="multipart/form-data" id="formularioCurso">
                            @csrf
                            @method('PUT')
                            
                            <!-- Digital -->
                            <div class="form-section-card shadow-sm" id="seccion-Digital">
                                <div class="material-title">
                                    <i class="fas fa-file-pdf"></i> Material Digital
                                    <span class="estado-archivo {{ $rutaLocal && $rutaLocal->rutaMaterialdeapoyo ? 'subido' : 'no-subido' }}" id="estadoArchivo-Digital">
                                        {{ $rutaLocal && $rutaLocal->rutaMaterialdeapoyo ? '✓ Archivo subido' : '✗ Sin archivo' }}
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="Digital" class="form-label">
                                            Digital
                                            <span class="estado-indicador" id="estado-Digital"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="text" name="Digital" id="Digital" 
                                                class="form-control" 
                                                value="{{ old('Digital', $curso->Digital) }}" 
                                                required
                                                oninput="validarPorcentaje(this)"
                                                onchange="validarPorcentaje(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="DriveDigital" class="form-label">
                                            Drive Digital
                                            <span class="estado-indicador" id="estado-DriveDigital"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                            <input type="text" name="DriveDigital" id="DriveDigital" 
                                                class="form-control" 
                                                value="{{ old('DriveDigital', $curso->DriveDigital) }}" 
                                                required
                                                oninput="validarCampo(this)"
                                                onchange="validarCampo(this)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="DigitalLocal" class="form-label">
                                            Subir archivo
                                            <span class="estado-indicador" id="estado-archivoDigital"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                            <input type="file" name="DigitalLocal" id="DigitalLocal" 
                                                class="form-control"
                                                onchange="validarArchivo(this, 'Digital')">
                                        </div>
                                        @if ($rutaLocal && $rutaLocal->rutaMaterialdeapoyo)
                                            <div class="mt-2 alert alert-success py-2 px-3 mb-0" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-circle me-1 text-success"></i> Ruta actual: {{ $rutaLocal->rutaMaterialdeapoyo }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Impreso Presentable -->
                            <div class="form-section-card shadow-sm" id="seccion-ImpresoPresentable">
                                <div class="material-title">
                                    <i class="fas fa-print"></i> Material Impreso y Presentable
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        @php
                                            use App\Models\Inscripcion;
                                            $cursoId = $curso->id;
                                            $participante = Inscripcion::where('curso_id', $cursoId)->count();
                                        @endphp
                                        <label for="Impreso_Presentable" class="form-label">
                                            Porcentaje del material impreso
                                            <span class="estado-indicador" id="estado-Impreso_Presentable"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            <select name="Impreso_Presentable" id="Impreso_Presentable" 
                                                class="form-select"
                                                onchange="validarSelect(this)">
                                                <option value="{{ $curso->Impreso_Presentable }}" selected>{{ $curso->Impreso_Presentable }} (Actual)</option>
                                                @for ($i = 1; $i <= $participante; $i++)
                                                    <option value="{{ $i }}/{{ $participante }}">{{ $i }}/{{ $participante }}</option>
                                                @endfor
                                            </select>
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
        if (campo.id === 'Digital' || campo.id === 'Impreso_Presentable') {
            validarPorcentaje(campo);
        } else if (campo.tagName === 'SELECT') {
            validarSelect(campo);
        } else {
            validarCampo(campo);
        }
    });
    
    // Validar archivo existente
    const rutaActual = document.querySelector('#seccion-Digital .alert-success');
    const indicador = document.getElementById('estado-archivoDigital');
    if (rutaActual) {
        if (indicador) indicador.className = 'estado-indicador estado-verde';
    } else {
        if (indicador) indicador.className = 'estado-indicador estado-rojo';
    }
    
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
    const secciones = ['Digital', 'ImpresoPresentable'];
    
    secciones.forEach(seccion => {
        const seccionCard = document.getElementById('seccion-' + seccion);
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