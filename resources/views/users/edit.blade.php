@extends('home')
@section('title', '- Editar Usuario')
@section('nav')

<style>
    .container {
        margin-top: 10% !important;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    label {
        font-weight: bold;
        text-align: center;
        display: block;
        width: 100%;
    }
    .botones {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
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
        margin-bottom: 20px;
    }
    .back-button-container {
        position: absolute;
        left: 0;
    }
</style>

<div class="container">
    <div class="header-container">
        <div class="back-button-container">
            <a href="{{ auth()->id() == $user->id ? route('profile') : route('users.index') }}" class="back-arrow" title="Regresar">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1>Editar Perfil</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}" id="editForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <div class="input-group">
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido</label>
            <div class="input-group">
                <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido', $user->apellido) }}" required readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <div class="input-group">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Nueva Contraseña (opcional)</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco para mantener la contraseña actual" readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <div class="input-group">
                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}" readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="edad">Edad</label>
            <div class="input-group">
                <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad', $user->edad) }}" min="18" max="90" readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="form-group">
            <label for="puesto">Puesto</label>
            <div class="input-group">
                <input type="text" name="puesto" id="puesto" class="form-control" value="{{ old('puesto', $user->puesto) }}" readonly>
                <span class="input-group-text d-none editing-indicator">Editando</span>
            </div>
        </div>

        <div class="botones">
            <button type="button" id="toggleEditButton" class="btn btn-primary">Editar</button>
            <button type="submit" class="btn btn-success" id="saveButton" disabled>Guardar Cambios</button>
            <button type="button" id="cancelButton" class="btn btn-danger" disabled>Cancelar</button>
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
            originalValues[input.id] = input.value;
        });

        // Función para habilitar edición
        toggleEditButton.addEventListener('click', function () {
            if (!isEditing) {
                // Habilitar edición
                formInputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.addEventListener('input', showEditingIndicator);
                });
                toggleEditButton.style.display = 'none'; // Ocultar botón editar
                saveButton.removeAttribute('disabled');
                cancelButton.removeAttribute('disabled');
                isEditing = true;
            }
        });

        // Cancelar edición y restaurar valores originales
        cancelButton.addEventListener('click', function () {
            formInputs.forEach(input => {
                input.value = originalValues[input.id];
                input.setAttribute('readonly', true);
                hideEditingIndicator(input);
            });
            toggleEditButton.style.display = 'inline-block'; // Mostrar de nuevo botón editar
            saveButton.setAttribute('disabled', true);
            cancelButton.setAttribute('disabled', true);
            isEditing = false;
        });

        // Mostrar "Editando" cuando el usuario modifica un campo
        function showEditingIndicator(event) {
            const input = event.target;
            const indicator = input.nextElementSibling;
            if (indicator && indicator.classList.contains('editing-indicator')) {
                indicator.classList.remove('d-none');
            }
        }

        // Ocultar "Editando" cuando se desactiva la edición
        function hideEditingIndicator(input) {
            const indicator = input.nextElementSibling;
            if (indicator && indicator.classList.contains('editing-indicator')) {
                indicator.classList.add('d-none');
            }
        }
    });
</script>
@endsection
