@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm border-0 p-4" style="width: 500px; border-radius: 15px;">
        <h3 class="text-center mb-4 text-primary">Editar Paso 2: Modalidad del Curso</h3>
        <form action="{{ route('cursos.update.paso', [$curso->id, 2]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label font-weight-bold">¿El curso es Virtual?</label>
                <select name="Virtual" class="form-select" required>
                    <option value="1" {{ $curso->virtual ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$curso->virtual ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label font-weight-bold">¿El curso es Presencial?</label>
                <select name="Presencial" class="form-select" required>
                    <option value="1" {{ $curso->presencial ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$curso->presencial ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label font-weight-bold">¿El curso es Mixto?</label>
                <select name="Mixto" class="form-select" required>
                    <option value="1" {{ $curso->mixto ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$curso->mixto ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mt-5 d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-primary btn-lg px-4">Actualizar Paso 2</button>
                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary btn-lg px-4">Regresar</a>
            </div>
        </form>
    </div>
</div>
@endsection
