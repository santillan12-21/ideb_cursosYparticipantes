@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 4: Documentos del Curso</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 4]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Temario</label>
                    <input type="text" name="Temario" class="form-control"
                           value="{{ $curso->Temario }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Temario</label>
                    <input type="text" name="DriveTemario" class="form-control"
                           value="{{ $curso->DriveTemario }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Itinerario</label>
                    <input type="text" name="Itinerario" class="form-control"
                           value="{{ $curso->Itinerario }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Itinerario</label>
                    <input type="text" name="DriveItinerario" class="form-control"
                           value="{{ $curso->DriveItinerario }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Planeación</label>
                    <input type="text" name="Planeación" class="form-control"
                           value="{{ $curso->Planeación }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Planeación</label>
                    <input type="text" name="DrivePlaneación" class="form-control"
                           value="{{ $curso->DrivePlaneación }}" required>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 4</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
