@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 4: Documentos del Curso</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 4]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Temario</label>
                    <input type="text" name="Temario" class="form-control"
                           value="{{ $curso->Temario }}" required>
                          <label for="">Editar Archivo</label>
                            <input type="file" name="TemarioLocal" class="form-control">
                           @if ($rutaLocal && $rutaLocal->rutaTemario)
                            <div class="mt-2 alert alert-success">
                                Ruta actual Temario: {{ $rutaLocal->rutaTemario }}
                            </div>
                        @endif
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
                        <label for="">Editar Archivo</label>
                            <input type="file" name="ItinerarioLocal" class="form-control">
                           @if ($rutaLocal && $rutaLocal->rutaItinerario)
                            <div class="mt-2 alert alert-success">
                                Ruta actual Itinerario: {{ $rutaLocal->rutaItinerario }}
                            </div>
                        @endif
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
                        <label for="">Editar Archivo</label>
                            <input type="file" name="PlaneaciónLocal" class="form-control">
                           @if ($rutaLocal && $rutaLocal->rutaPlaneacion)
                            <div class="mt-2 alert alert-success">
                                Ruta actual Planeación: {{ $rutaLocal->rutaPlaneacion }}
                            </div>
                        @endif
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
