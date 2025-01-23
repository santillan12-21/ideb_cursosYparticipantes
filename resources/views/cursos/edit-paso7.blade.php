@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 7: Documentación STPS y Certificados</h3>

            <form action="{{ route('cursos.update.paso', [$curso->id, 7]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Fecha de Registro STPS</label>
                    <input type="date" name="FechadeRegistro_STPS" class="form-control"
                           value="{{ $curso->FechadeRegistro_STPS }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Formato DC5</label>
                    <input type="text" name="Formato_DC5" class="form-control" required
                           value="{{ $curso->Formato_DC5 }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Formato DC5 - ¿Tiene firma?</label>
                    <select name="Formato_DC5_Tienefirma" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Si" {{ $curso->Formato_DC5_Tienefirma == 'Si' ? 'selected' : '' }}>Sí</option>
                        <option value="No" {{ $curso->Formato_DC5_Tienefirma == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Certificado de Comprobación</label>
                    <select name="Certificadodecomprobacion" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Ya obtenida" {{ $curso->Certificadodecomprobacion == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                        <option value="En proceso" {{ $curso->Certificadodecomprobacion == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="No obtenida" {{ $curso->Certificadodecomprobacion == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive de Certificado de Comprobación</label>
                    <input type="text" name="DrivedeCertificadodecomprobacion" class="form-control" required
                           value="{{ $curso->DrivedeCertificadodecomprobacion }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Carta Poder - ¿Tiene firma?</label>
                    <select name="Cartapoder_tienefirma" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Si" {{ $curso->Cartapoder_tienefirma == 'Si' ? 'selected' : '' }}>Sí</option>
                        <option value="No" {{ $curso->Cartapoder_tienefirma == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Carta Poder</label>
                    <input type="text" name="DriveCartapoder" class="form-control" required
                           value="{{ $curso->DriveCartapoder }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">UDEMY</label>
                    <select name="UDEMY" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Prellenado" {{ $curso->UDEMY == 'Prellenado' ? 'selected' : '' }}>Prellenado</option>
                        <option value="No se ha prellenado" {{ $curso->UDEMY == 'No se ha prellenado' ? 'selected' : '' }}>No se ha prellenado</option>
                    </select>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 7</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
