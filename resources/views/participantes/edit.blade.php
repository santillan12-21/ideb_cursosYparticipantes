@extends('layouts.app')
@section('content')

<style>
    .back-arrow {
        font-size: 1.5rem;
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }
    .back-arrow:hover {
        color: #007bff;
    }
    .header-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 30px;
    }
    .back-button-container {
        position: absolute;
        left: 0;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 25px;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        font-weight: bold;
        color: #0d6efd;
        border-radius: 15px 15px 0 0 !important;
        padding: 15px 20px;
    }
    .form-label {
        font-weight: 600;
        color: #555;
    }
    .input-group-text {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    .botones {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .editing-indicator {
        font-size: 0.75rem;
        background-color: #e7f1ff !important;
        color: #0d6efd !important;
    }
    .section-icon {
        margin-right: 10px;
    }
</style>

<div class="container mt-5">
    <div class="header-container">
        <div class="back-button-container">
            <a href="{{ route('participantes.index') }}" class="back-arrow" title="Regresar">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h2 class="text-center"><i class="fas fa-user-edit section-icon"></i>Editar Participante</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('participantes.update', ['id' => $participante->id]) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        <!-- Sección 1: Datos Personales -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-id-card section-icon"></i>Información Personal
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="N" class="form-label">N° de nomenclatura</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            <input type="text" class="form-control" id="N" name="N" value="{{ old('N', $participante->N) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="NombredelPostulante" name="NombredelPostulante" value="{{ old('NombredelPostulante', $participante->NombredelPostulante) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="Correo" name="Correo" value="{{ old('Correo', $participante->Correo) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="Telefono" class="form-label">Teléfono (10 dígitos)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control" id="Telefono" name="Telefono" 
                                   value="{{ old('Telefono', $participante->Telefono) }}" 
                                   maxlength="10" pattern="\d{10}" title="El teléfono debe tener 10 dígitos numéricos" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="Edad" class="form-label">Edad</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                            <input type="number" class="form-control" id="Edad" name="Edad" value="{{ old('Edad', $participante->Edad) }}" min="18" max="90" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="Direccion" class="form-label">Dirección</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" class="form-control" id="Direccion" name="Direccion" value="{{ old('Direccion', $participante->Direccion) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="Curp" class="form-label">CURP (18 caracteres)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                            <input type="text" class="form-control" id="Curp" name="Curp" 
                                   value="{{ old('Curp', $participante->Curp) }}" 
                                   maxlength="18" minlength="18" style="text-transform: uppercase;" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Escolaridad" class="form-label">Escolaridad</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                            <select class="form-select form-control" id="Escolaridad" name="Escolaridad" required disabled>
                                <option value="Primaria" {{ $participante->Escolaridad == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                <option value="Secundaria" {{ $participante->Escolaridad == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                                <option value="Preparatoria" {{ $participante->Escolaridad == 'Preparatoria' ? 'selected' : '' }}>Preparatoria</option>
                                <option value="Licenciatura" {{ $participante->Escolaridad == 'Licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                <option value="Maestría" {{ $participante->Escolaridad == 'Maestría' ? 'selected' : '' }}>Maestría</option>
                                <option value="Doctorado" {{ $participante->Escolaridad == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                                <option value="Otro" {{ !in_array($participante->Escolaridad, ['Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Maestría', 'Doctorado']) ? 'selected' : '' }}>Otro</option>
                            </select>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Ocupacion" class="form-label">Ocupación</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                            <input type="text" class="form-control" id="Ocupacion" name="Ocupacion" value="{{ old('Ocupacion', $participante->Ocupacion) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 2: Información de Empresa -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-building section-icon"></i>Información de Empresa
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="Empresa" class="form-label">Nombre de la Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-industry"></i></span>
                            <input type="text" class="form-control" id="Empresa" name="Empresa" value="{{ old('Empresa', $participante->Empresa) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Puesto" class="form-label">Puesto en la Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                            <input type="text" class="form-control" id="Puesto" name="Puesto" value="{{ old('Puesto', $participante->Puesto) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="RazónSocial" class="form-label">Razón Social</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                            <input type="text" class="form-control" id="RazónSocial" name="RazónSocial" value="{{ old('RazónSocial', $participante->RazónSocial) }}" readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="RFCEmpresa" class="form-label">RFC Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input type="text" class="form-control" id="RFCEmpresa" name="RFCEmpresa" value="{{ old('RFCEmpresa', $participante->RFCEmpresa) }}" readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 3: Detalles de Inscripción y Pago -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-money-check-alt section-icon"></i>Inscripción y Pago
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12 mb-2">
                        <label for="cursos" class="form-label">Cursos Inscritos</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select class="form-select form-control" id="cursos" name="cursos[]" multiple required disabled>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}"
                                            data-fecha="{{ $curso->FechadeInicio }}"
                                            {{ in_array($curso->id, $participante->cursos->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $curso->NombredelCurso }} ({{ $curso->FechadeInicio }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                        <small class="text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varios.</small>
                    </div>
                    <div class="col-md-4">
                        <label for="FechadelCurso" class="form-label">Fecha del Curso</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input type="date" class="form-control" id="FechadelCurso" name="FechadelCurso" value="{{ old('FechadelCurso', $participante->FechadelCurso) }}" required readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="Pago" class="form-label">Monto de Pago</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input type="text" class="form-control" id="Pago" name="Pago" value="{{ old('Pago', $participante->Pago ?: '0.00') }}" readonly>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="EstadoDePago" class="form-label">Estado de Pago</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                            <select class="form-select form-control" id="EstadoDePago" name="EstadoDePago" required disabled>
                                <option value="" disabled {{ !old('EstadoDePago', $participante->EstadoDePago) ? 'selected' : '' }}>Seleccione el estado</option>
                                <option value="Pagado" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="Pendiente" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Anticipo" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Anticipo' ? 'selected' : '' }}>Anticipo</option>
                                <option value="Cancelado" {{ old('EstadoDePago', $participante->EstadoDePago) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <span class="input-group-text d-none editing-indicator">Editando</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="botones">
            <button type="button" id="toggleEditButton" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-edit"></i> Editar Datos
            </button>
            <button type="submit" class="btn btn-success btn-lg shadow-sm" id="saveButton" disabled>
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <button type="button" id="cancelButton" class="btn btn-danger btn-lg shadow-sm" disabled>
                <i class="fas fa-times"></i> Cancelar
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleEditButton = document.getElementById('toggleEditButton');
        const cancelButton = document.getElementById('cancelButton');
        const saveButton = document.getElementById('saveButton');
        const formInputs = document.querySelectorAll('#editForm .form-control');
        const originalValues = {};
        let isEditing = false;

        // Almacenar valores originales
        formInputs.forEach(input => {
            if (input.tagName === 'SELECT' && input.multiple) {
                originalValues[input.id] = Array.from(input.selectedOptions).map(option => option.value);
            } else {
                originalValues[input.id] = input.value;
            }
        });

        // Función para habilitar edición
        toggleEditButton.addEventListener('click', function () {
            if (!isEditing) {
                formInputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                    input.addEventListener('input', showEditingIndicator);
                    input.addEventListener('change', showEditingIndicator);
                });
                toggleEditButton.style.display = 'none';
                saveButton.removeAttribute('disabled');
                cancelButton.removeAttribute('disabled');
                isEditing = true;
            }
        });

        // Cancelar edición y restaurar valores originales
        cancelButton.addEventListener('click', function () {
            formInputs.forEach(input => {
                if (input.tagName === 'SELECT' && input.multiple) {
                    const values = originalValues[input.id];
                    Array.from(input.options).forEach(option => {
                        option.selected = values.includes(option.value);
                    });
                } else {
                    input.value = originalValues[input.id];
                }
                input.setAttribute('readonly', true);
                if (input.tagName === 'SELECT') input.setAttribute('disabled', true);
                hideEditingIndicator(input);
            });
            toggleEditButton.style.display = 'inline-block';
            saveButton.setAttribute('disabled', true);
            cancelButton.setAttribute('disabled', true);
            isEditing = false;
        });

        function showEditingIndicator(event) {
            const input = event.target;
            const group = input.closest('.input-group');
            if (group) {
                const indicator = group.querySelector('.editing-indicator');
                if (indicator) indicator.classList.remove('d-none');
            }
        }

        function hideEditingIndicator(input) {
            const group = input.closest('.input-group');
            if (group) {
                const indicator = group.querySelector('.editing-indicator');
                if (indicator) indicator.classList.add('d-none');
            }
        }

        const estadoPagoSelect = document.getElementById('EstadoDePago');
        const pagoInput = document.getElementById('Pago');
        const cursosSelect = document.getElementById('cursos');
        const fechaCursoInput = document.getElementById('FechadelCurso');

        estadoPagoSelect.addEventListener('change', function () {
            if (estadoPagoSelect.value === 'Cancelado') {
                pagoInput.value = '0.00';
            }
        });

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
