@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 3: Formato de Flyer / Imagen</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 3]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Sin Fecha</label>
                    <input type="text" name="SinFecha" class="form-control"
                           value="{{ $curso->SinFecha }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Sin Fecha</label>
                    <input type="text" name="DriveSinFecha" class="form-control"
                           value="{{ $curso->DriveSinFecha }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Facebook</label>
                    <input type="text" name="Facebook" class="form-control"
                           value="{{ $curso->Facebook }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Facebook</label>
                    <input type="text" name="DriveFacebook" class="form-control"
                           value="{{ $curso->DriveFacebook }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">LinkedIn</label>
                    <input type="text" name="Linkedin" class="form-control"
                           value="{{ $curso->Linkedin }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive LinkedIn</label>
                    <input type="text" name="DriveLinkedin" class="form-control"
                           value="{{ $curso->DriveLinkedin }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="Instagram" class="form-control"
                           value="{{ $curso->Instagram }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Instagram</label>
                    <input type="text" name="DriveInstagram" class="form-control"
                           value="{{ $curso->DriveInstagram }}" required>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 3</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
