@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Registrar Participante</h2>
    <form action="{{ route('participantes.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="N" class="form-label">N° de nomenclatura</label>
                <input type="text" class="form-control" name="N" required>
            </div>
            <div class="col-md-4">
                <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
                <input type="text" class="form-control" name="NombredelPostulante" required>
            </div>
            <div class="col-md-4">
                <label for="Correo" class="form-label">Correo</label>
                <input type="email" class="form-control" name="Correo" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="Telefono" required>
            </div>
            <div class="col-md-4">
                <label for="Edad" class="form-label">Edad</label>
                <input type="number" class="form-control" name="Edad" required>
            </div>
            <div class="col-md-4">
                <label for="Direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="Direccion" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Escolaridad" class="form-label">Escolaridad</label>
                <input type="text" class="form-control" name="Escolaridad" required>
            </div>
            <div class="col-md-4">
                <label for="Curp" class="form-label">CURP</label>
                <input type="text" class="form-control" name="Curp" required>
            </div>
            <div class="col-md-4">
                <label for="Empresa" class="form-label">Empresa</label>
                <input type="text" class="form-control" name="Empresa" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" name="Puesto" required>
            </div>
            <div class="col-md-4">
                <label for="Pago" class="form-label">Pago</label>
                <input type="text" class="form-control" name="Pago" required>
            </div>
            <div class="col-md-4">
                <label for="FechadelCurso" class="form-label">Fecha del Curso</label>
                <input type="date" class="form-control" name="FechadelCurso" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="CursoInscrito" class="form-label">Curso Inscrito</label>
                    <input type="text" class="form-control" name="CursoInscrito" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="EstadoDePago" class="form-label">Estado de Pago</label>
                <select class="form-select" name="EstadoDePago" required>
                    <option value="" disabled selected>Seleccione el estado</option>
                    <option value="Curso Pagado">Curso Pagado</option>
                    <option value="Pago Pendiente">Pago Pendiente</option>
                    <option value="Anticipo">Anticipo</option>
                    <option value="No Pagado">No Pagado</option>
                </select>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('participantes.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>
@endsection
