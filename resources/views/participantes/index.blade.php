@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inscripción a Cursos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('participantes.store') }}" method="POST">
        @csrf

        <!-- Nuevo campo para N -->
        <div class="mb-3">
            <label>Número de participante</label>
            <input type="text" name="N" class="form-control"> <!-- Campo opcional -->
        </div>

        <div class="mb-3">
            <label>Nombre del Postulante</label>
            <input type="text" name="NombredelPostulante" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="Correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="Telefono" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Edad</label>
            <input type="number" name="Edad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="Direccion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Escolaridad</label>
            <input type="text" name="Escolaridad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>CURP</label>
            <input type="text" name="Curp" class="form-control" required>
        </div>

        <!-- Nuevos campos: RazonSocial y RFCEmpresa -->
        <div class="mb-3">
            <label>Razón Social</label>
            <input type="text" name="RazonSocial" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>RFC de la Empresa</label>
            <input type="text" name="RFCEmpresa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Empresa</label>
            <input type="text" name="Empresa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Puesto</label>
            <input type="text" name="Puesto" class="form-control" required>
        </div>

        <!-- Campo de Pago -->
        <div class="mb-3">
            <label>Pago</label>
            <input type="text" name="Pago" class="form-control" required>
        </div>

        <!-- Campo de Estado de Pago como desplegable -->
        <div class="mb-3">
            <label>Estado de Pago</label>
            <select name="EstadoDePago" class="form-control" required>
                <option value="" disabled selected>Opciones de Pago</option>
                <option value="Pagado">Pagado</option>
                <option value="Anticipo">Anticipo</option>
                <option value="No Pagado">No Pagado</option>
            </select>
        </div>

        <!-- Fecha del Curso -->
        <div class="mb-3">
            <label>Fecha del Curso</label>
            <input type="date" name="FechadelCurso" class="form-control" required>
        </div>

        <!-- Seleccionar Cursos -->
        <div class="mb-3">
            <label>Seleccionar Cursos</label>
            <select name="CursoInscrito[]" class="form-control" multiple required>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->NombredelCurso }}</option>
                @endforeach
            </select>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Inscribirse</button>
    </form>

    <!-- Tabla de Participantes Inscritos -->
    <h3 class="mt-5">Participantes Inscritos</h3>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Cursos Inscritos</th>
        </tr>
        @foreach($participantes as $participante)
        <tr>
            <td>{{ $participante->NombredelPostulante }}</td>
            <td>
                @foreach($participante->cursos as $curso)
                    {{ $curso->NombredelCurso }} ({{ $curso->pivot->FechadelCurso }})<br/>
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
