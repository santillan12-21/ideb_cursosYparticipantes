@extends('layouts.app') <!-- Asegúrate de tener un layout base -->

@section('content')
<div class="container">
    {{ dd($errors) }}
    <!-- Mostrar mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Registrar Nuevo Participante</h2>
    <form action="{{ route('participantes.store') }}" method="POST">
        @csrf <!-- Token CSRF para protección contra ataques -->
        <div class="mb-3">
            <label for="N" class="form-label">Número de Participante (N)</label>
            <input type="text" class="form-control" id="N" name="N" required>
        </div>
        <div class="mb-3">
            <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
            <input type="text" class="form-control" id="NombredelPostulante" name="NombredelPostulante" required>
        </div>
        <div class="mb-3">
            <label for="Correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="Correo" name="Correo" required>
        </div>
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" required>
        </div>
        <div class="mb-3">
            <label for="Edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="Edad" name="Edad" required>
        </div>
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" required>
        </div>
        <div class="mb-3">
            <label for="Escolaridad" class="form-label">Escolaridad</label>
            <input type="text" class="form-control" id="Escolaridad" name="Escolaridad" required>
        </div>
        <div class="mb-3">
            <label for="Curp" class="form-label">CURP</label>
            <input type="text" class="form-control" id="Curp" name="Curp" required>
        </div>
        <div class="mb-3">
            <label for="RazónSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="RazónSocial" name="RazónSocial" required>
        </div>
        <div class="mb-3">
            <label for="Empresa" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="Empresa" name="Empresa" required>
        </div>
        <div class="mb-3">
            <label for="RFCEmpresa" class="form-label">RFC de la Empresa</label>
            <input type="text" class="form-control" id="RFCEmpresa" name="RFCEmpresa" required>
        </div>
        <div class="mb-3">
            <label for="Puesto" class="form-label">Puesto</label>
            <input type="text" class="form-control" id="Puesto" name="Puesto" required>
        </div>
        <!-- Pago -->
        <div class="mb-3">
            <label for="Pago" class="form-label">Pago</label>
            <input type="text" class="form-control" id="Pago" name="Pago" required>
        </div>
        <!-- Estado de Pago -->
        <div class="mb-3">
            <label for="EstadoDePago" class="form-label">Estado de Pago</label>
            <select class="form-select" id="EstadoDePago" name="EstadoDePago" required>
                <option value="" disabled selected>Opciones de Pago</option>
                <option value="Pagado">Pagado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Anticipo">Anticipo</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="FechadelCurso" class="form-label">Fecha del Curso</label>
            <input type="date" class="form-control" id="FechadelCurso" name="FechadelCurso" required>
        </div>
        <!-- Selección de cursos -->
        <div class="mb-3">
            <label for="cursos" class="form-label">Selecciona los cursos en los que deseas inscribirte:</label>
            <select class="form-select" id="cursos" name="cursos[]" multiple required>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->NombredelCurso }}</option>
                @endforeach
            </select>
        </div>
        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
