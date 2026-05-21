@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0">Editar Paso 7: Documentación STPS y Certificados</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cursos.update.paso', [$curso->id, 7]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><b>Fecha de Registro STPS</b></label>
                                <input type="date" name="FechadeRegistro_STPS" class="form-control"
                                       value="{{ $curso->fecha_registro_stps }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><b>Formato DC5</b></label>
                                <input type="text" name="Formato_DC5" class="form-control"
                                       value="{{ $curso->formato_dc5 }}" placeholder="Nombre o referencia del formato">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><b>Formato DC5 - ¿Tiene firma?</b></label>
                                <select name="Formato_DC5_Tienefirma" class="form-select">
                                    <option value="1" {{ $curso->formato_dc5_tiene_firma ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ !$curso->formato_dc5_tiene_firma ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><b>Certificado de Comprobación</b></label>
                                <select name="Certificadodecomprobacion" class="form-select">
                                    <option value="Ya obtenida" {{ $curso->certificado_comprobacion == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                                    <option value="En proceso" {{ $curso->certificado_comprobacion == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                    <option value="No obtenida" {{ $curso->certificado_comprobacion == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Drive de Certificado de Comprobación</b></label>
                            <input type="text" name="DrivedeCertificadodecomprobacion" class="form-control"
                                   value="{{ $curso->drive_certificado_comprobacion }}" placeholder="Pegue el enlace de Drive aquí">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><b>Carta Poder - ¿Tiene firma?</b></label>
                                <select name="Cartapoder_tienefirma" class="form-select">
                                    <option value="1" {{ $curso->carta_poder_tiene_firma ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ !$curso->carta_poder_tiene_firma ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><b>UDEMY</b></label>
                                <select name="UDEMY" class="form-select">
                                    <option value="1" {{ $curso->udemy ? 'selected' : '' }}>Prellenado / Sí</option>
                                    <option value="0" {{ !$curso->udemy ? 'selected' : '' }}>No / No se ha prellenado</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><b>Drive Carta Poder</b></label>
                            <input type="text" name="DriveCartapoder" class="form-control"
                                   value="{{ $curso->drive_carta_poder }}" placeholder="Pegue el enlace de Drive aquí">
                        </div>

                        <div class="mt-5 d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Actualizar Paso 7
                            </button>
                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary btn-lg px-5">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
