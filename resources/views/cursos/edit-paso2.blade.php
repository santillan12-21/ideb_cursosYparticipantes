@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center form-container">
    <div class="w-50">
        <h3 class="text-center mb-4">Editar Paso 2: Modalidad del Curso</h3>
        <form action="{{ route('cursos.update.paso', [$curso->id, 2]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <select name="Virtual" class="form-control" required>
                    <option value="" disabled>¿El curso es Virtual?</option>
                    <option value="Si" {{ $curso->Virtual == 'Si' ? 'selected' : '' }}>Sí</option>
                    <option value="No" {{ $curso->Virtual == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mb-3">
                <select name="Presencial" class="form-control" required>
                    <option value="" disabled>¿El curso es Presencial?</option>
                    <option value="Si" {{ $curso->Presencial == 'Si' ? 'selected' : '' }}>Sí</option>
                    <option value="No" {{ $curso->Presencial == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mb-3">
                <select name="Mixto" class="form-control" required>
                    <option value="" disabled>¿El curso es Mixto?</option>
                    <option value="Si" {{ $curso->Mixto == 'Si' ? 'selected' : '' }}>Sí</option>
                    <option value="No" {{ $curso->Mixto == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mb-3 d-flex justify-content-between">
                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                <button type="submit" class="btn btn-primary">Actualizar Paso 2</button>
            </div>
        </form>
    </div>
</div>
@endsection
