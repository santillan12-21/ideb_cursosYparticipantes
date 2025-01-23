@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 6: Documentos de Evaluación</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 6]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Presentación</label>
                    <input type="text" name="Presentación" class="form-control"
                           value="{{ $curso->Presentación }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Evaluación Diagnóstica</label>
                    <input type="text" name="Evaluación_diagnostica" class="form-control"
                           value="{{ $curso->Evaluación_diagnostica }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Evaluación de Satisfacción</label>
                    <input type="text" name="EvaluaciondeSatisfacción" class="form-control"
                           value="{{ $curso->EvaluaciondeSatisfacción }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Evaluación Final</label>
                    <input type="text" name="EvaluacionFinal" class="form-control"
                           value="{{ $curso->EvaluacionFinal }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DC3</label>
                    <select name="DC3" class="form-select" required>
                        <option value="" disabled>Seleccione el estado del DC3</option>
                        <option value="Tiene DC3" {{ $curso->DC3 == 'Tiene DC3' ? 'selected' : '' }}>Tiene DC3</option>
                        <option value="No tiene DC3" {{ $curso->DC3 == 'No tiene DC3' ? 'selected' : '' }}>No tiene DC3</option>
                        <option value="Por confirmar" {{ $curso->DC3 == 'Por confirmar' ? 'selected' : '' }}>Por confirmar</option>
                    </select>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 6</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
