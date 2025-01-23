@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 5: Material de Apoyo</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 5]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Digital</label>
                    <input type="text" name="Digital" class="form-control"
                           value="{{ $curso->Digital }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Digital</label>
                    <input type="text" name="DriveDigital" class="form-control"
                           value="{{ $curso->DriveDigital }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Impreso Presentable</label>
                    <input type="text" name="Impreso_Presentable" class="form-control"
                           value="{{ $curso->Impreso_Presentable }}" required>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 5</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
