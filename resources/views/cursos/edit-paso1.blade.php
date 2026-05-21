@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Paso 1: Datos del Curso</h2>
    <form action="{{ route('cursos.update.paso', [$curso->id, 1]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nomenclatura</label>
            <input type="text" name="Nomenclatura" class="form-control @error('Nomenclatura') is-invalid @enderror" placeholder="Nomenclatura"
                   value="{{ old('Nomenclatura', $curso->Nomenclatura) }}" required>
            @error('Nomenclatura')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <input type="text" name="NombredelCurso" class="form-control" placeholder="Nombre del Curso"
                   value="{{ $curso->NombredelCurso }}" required>
        </div>
        <div class="mb-3">
            <textarea name="DescripciondeCurso" class="form-control" rows="3" placeholder="Descripción del Curso" required>{{ $curso->DescripciondeCurso }}</textarea>
        </div>
        <div class="mb-3">
            <input type="number" step="0.01" name="CostodelCurso" class="form-control" placeholder="Costo del Curso ($)"
                   value="{{ $curso->CostodelCurso }}" required>
        </div>
        <div class="mb-3">
            <input type="text" name="InstructorResponsable" class="form-control" placeholder="Instructor Responsable"
                   value="{{ $curso->InstructorResponsable }}" required>
        </div>
        <div class="mb-3">
            <label>Fecha de Inicio</label>
            <input type="date" name="FechadeInicio" class="form-control"
                   value="{{ $curso->FechadeInicio }}" required>
        </div>
        <div class="mb-3">
            <label>Fecha de Término</label>
            <input type="date" name="FechadeTermino" class="form-control"
                   value="{{ $curso->FechadeTermino }}" required>
        </div>
        <div class="mb-3">
            <label>Duracion del curso</label>
            <input type="text" name="Duracioncurso" class="form-control" placeholder="Duración del Curso (ej: 9 horas)"
                   value="{{ $curso->Duracioncurso }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Paso 1</button>
        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
    </form>

</div>
@endsection
