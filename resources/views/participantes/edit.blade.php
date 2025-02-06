@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Participante</h2>
    <form action="{{ route('participantes.update', ['id' => $participante->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- N° de nomenclatura -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="N" class="form-label">N° de nomenclatura</label>
                <input type="text" class="form-control" id="N" name="N" value="{{ old('N', $participante->N) }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
                <input type="text" class="form-control" id="NombredelPostulante" name="NombredelPostulante" value="{{ old('NombredelPostulante', $participante->NombredelPostulante) }}" required>
            </div>
            <div class="col-md-4">
                <label for="Correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="Correo" name="Correo" value="{{ old('Correo', $participante->Correo) }}" required>
            </div>
        </div>
        <!-- Teléfono, Edad, Dirección -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="Telefono" name="Telefono" value="{{ old('Telefono', $participante->Telefono) }}" required>
            </div>
            <div class="col-md-4">
                <label for="Edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="Edad" name="Edad" value="{{ old('Edad', $participante->Edad) }}" required>
            </div>
            <div class="col-md-4">
                <label for="Direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="Direccion" name="Direccion" value="{{ old('Direccion', $participante->Direccion) }}" required>
            </div>
        </div>
        <!-- Escolaridad, CURP, Empresa -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Escolaridad" class="form-label">Escolaridad</label>
                <input type="text" class="form-control" id="Escolaridad" name="Escolaridad" value="{{ old('Escolaridad', $participante->Escolaridad) }}" required>
            </div>
            <div class="col-md-4">
                <label for="Curp" class="form-label">CURP</label>
                <input type="text" class="form-control" id="Curp" name="Curp" value="{{ old('Curp', $participante->Curp) }}" required>
            </div>
            <div class="col-md-4">
                <label for="Empresa" class="form-label">Empresa</label>
                <input type="text" class="form-control" id="Empresa" name="Empresa" value="{{ old('Empresa', $participante->Empresa) }}" required>
            </div>
        </div>
        <!-- Razón Social y RFC Empresa -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="RazónSocial" class="form-label">Razón Social</label>
                <input type="text" class="form-control" id="RazónSocial" name="RazónSocial" value="{{ old('RazónSocial', $participante->RazónSocial) }}">
            </div>
            <div class="col-md-6">
                <label for="RFCEmpresa" class="form-label">RFC Empresa</label>
                <input type="text" class="form-control" id="RFCEmpresa" name="RFCEmpresa" value="{{ old('RFCEmpresa', $participante->RFCEmpresa) }}">
            </div>
        </div>
        <!-- Puesto, Pago, Fecha del Curso -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="Puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="Puesto" name="Puesto" value="{{ old('Puesto', $participante->Puesto) }}" required>
            </div>
            <div class="col-md-4">
                <label for="Pago" class="form-label">Pago</label>
                <input type="text" class="form-control" id="Pago" name="Pago" value="{{ old('Pago', $participante->Pago) }}" required>
            </div>
            <div class="col-md-4">
                <label for="FechadelCurso" class="form-label">Fecha del Curso</label>
                <input type="date" class="form-control" id="FechadelCurso" name="FechadelCurso" value="{{ old('FechadelCurso', $participante->FechadelCurso) }}" required>
            </div>
        </div>
        <!-- Estado de Pago -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="EstadoDePago" class="form-label">Estado de Pago</label>
                <select class="form-select" id="EstadoDePago" name="EstadoDePago" required>
                    <option value="" disabled {{ !old('EstadoDePago', $participante->EstadoDePago) ? 'selected' : '' }}>Seleccione el estado</option>
                    <option value="Curso Pagado" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Curso Pagado' ? 'selected' : '' }}>Curso Pagado</option>
                    <option value="Pago Pendiente" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Pago Pendiente' ? 'selected' : '' }}>Pago Pendiente</option>
                    <option value="Anticipo" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Anticipo' ? 'selected' : '' }}>Anticipo</option>
                    <option value="No Pagado" {{ old('EstadoDePago', $participante->EstadoDePago) == 'No Pagado' ? 'selected' : '' }}>No Pagado</option>
                </select>
        </div>

        <!-- Curso -->
        <div class="mb-3">
            <label for="cursos" class="form-label">Selecciona los cursos en los que deseas inscribirte:</label>
            <select class="form-select" id="cursos" name="cursos[]" multiple required>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}"
                            data-fecha="{{ $curso->FechadeInicio }}"
                            {{ in_array($curso->id, $participante->cursos->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $curso->NombredelCurso }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Curso -->
        <div class="mb-3">
            <div class="mb-3">
                <label for="cursos" class="form-label">Selecciona los cursos en los que deseas inscribirte:</label>
                <select class="form-select" id="cursos" name="cursos[]" multiple required>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso->id }}"
                                data-fecha="{{ $curso->FechadeInicio }}"
                                {{ in_array($curso->id, $participante->cursos->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $curso->NombredelCurso }}
                        </option>
                    @endforeach
                </select>
            </div>
        <!-- Botones de acción -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('participantes.index') }}" class="btn btn-danger">Cancelar</a>
        </div>


        <script>
            //Funcion para la opcion de cancelar y convierta el pago en $0
            document.addEventListener('DOMContentLoaded', function () {
            const estadoPagoSelect = document.getElementById('EstadoDePago');
            const pagoInput = document.getElementById('Pago');
            const cursosSelect = document.getElementById('cursos');
            const fechaCursoInput = document.getElementById('FechadelCurso');

            // Manejar cambios en estado de pago
            estadoPagoSelect.addEventListener('change', function () {
                if (estadoPagoSelect.value === 'Cancelado') {
                    pagoInput.value = '$0.00';
                }
            });

            // Manejar cambios en selección de cursos
            cursosSelect.addEventListener('change', function () {
                const selectedOptions = Array.from(cursosSelect.selectedOptions);
                if (selectedOptions.length > 0) {
                    const firstSelectedOption = selectedOptions[0];
                    const fecha = firstSelectedOption.dataset.fecha;
                    if (fecha) {
                        fechaCursoInput.value = fecha;
                    }
                }
            });
        });
            </script>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const estadoPagoSelect = document.getElementById('EstadoDePago');
        const pagoInput = document.getElementById('Pago');
        const cursosSelect = document.getElementById('cursos');
        const fechaCursoInput = document.getElementById('FechadelCurso');

        // Manejar cambios en estado de pago
        estadoPagoSelect.addEventListener('change', function () {
            if (estadoPagoSelect.value === 'Cancelado') {
                pagoInput.value = '$0.00';
            }
        });

        // Manejar cambios en selección de cursos
        cursosSelect.addEventListener('change', function () {
            const selectedOptions = Array.from(cursosSelect.selectedOptions);
            if (selectedOptions.length > 0) {
                const firstSelectedOption = selectedOptions[0];
                const fecha = firstSelectedOption.dataset.fecha;
                if (fecha) {
                    fechaCursoInput.value = fecha;
                }
            }
        });
    });
</script>
@endsection
