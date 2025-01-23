@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Participante</h2>
    <form action="{{ route('participantes.update', $participante->N) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="N" class="form-label">N° de nomenclatura</label>
                <input type="text" class="form-control" name="N" value="{{ $participante->N }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
                <input type="text" class="form-control" name="NombredelPostulante" value="{{ $participante->NombredelPostulante }}" required>
            </div>
            <div class="col-md-4">
                <label for="Correo" class="form-label">Correo</label>
                <input type="email" class="form-control" name="Correo" value="{{ $participante->Correo }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="Telefono" value="{{ $participante->Telefono }}" required>
            </div>
            <div class="col-md-4">
                <label for="Edad" class="form-label">Edad</label>
                <input type="number" class="form-control" name="Edad" value="{{ $participante->Edad }}" required>
            </div>
            <div class="col-md-4">
                <label for="Direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="Direccion" value="{{ $participante->Direccion }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Escolaridad" class="form-label">Escolaridad</label>
                <input type="text" class="form-control" name="Escolaridad" value="{{ $participante->Escolaridad }}" required>
            </div>
            <div class="col-md-4">
                <label for="Curp" class="form-label">CURP</label>
                <input type="text" class="form-control" name="Curp" value="{{ $participante->Curp }}" required>
            </div>
            <div class="col-md-4">
                <label for="Empresa" class="form-label">Empresa</label>
                <input type="text" class="form-control" name="Empresa" value="{{ $participante->Empresa }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" name="Puesto" value="{{ $participante->Puesto }}" required>
            </div>
            <div class="col-md-4">
                <label for="Pago" class="form-label">Pago</label>
                <input type="text" class="form-control" name="Pago" value="{{ $participante->Pago }}" required>
            </div>
            <div class="col-md-4">
                <label for="FechadelCurso" class="form-label">Fecha del Curso</label>
                <input type="date" class="form-control" name="FechadelCurso" value="{{ $participante->FechadelCurso }}" required>
            </div>
        </div>

        <!-- Nuevo campo Curso Inscrito -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="CursoInscrito" class="form-label">Curso Inscrito</label>
                <input type="text" class="form-control" name="CursoInscrito" value="{{ $participante->CursoInscrito }}" required>
            </div>
        </div>

        <!-- Nuevo campo Estado de Pago -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="EstadoDePago" class="form-label">Estado de Pago</label>
                <select class="form-select" name="EstadoDePago" required>
                    <option value="" disabled selected>Seleccione el estado</option>
                    <option value="Curso Pagado" {{ $participante->EstadoDePago == 'Curso Pagado' ? 'selected' : '' }}>Curso Pagado</option>
                    <option value="Pago Pendiente" {{ $participante->EstadoDePago == 'Pago Pendiente' ? 'selected' : '' }}>Pago Pendiente</option>
                    <option value="Anticipo" {{ $participante->EstadoDePago == 'Anticipo' ? 'selected' : '' }}>Anticipo</option>
                    <option value="No Pagado" {{ $participante->EstadoDePago == 'No Pagado' ? 'selected' : '' }}>No Pagado</option>
                </select>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('participantes.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>
@endsection
