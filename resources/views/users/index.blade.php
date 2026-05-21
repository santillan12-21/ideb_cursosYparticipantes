@extends('home')
@section('title', '- Lista de Usuarios')
@section('content')

<style>
    .success-message {
        color: green;
        margin-bottom: 20px;
    }
    .users-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .users-table th, .users-table td {
        border: 1px solid #ddd !important;
        padding: 10px !important;
        text-align: left !important;
    }
    .users-table th {
        background-color: #000;
        color: #fff;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .btn-custom {
        background-color: #000;
        color: #fff;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
    }
    .btn-custom:hover {
        background-color: #444;
        color: white;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid py-4">
    <h1>Lista de Usuarios</h1>
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn-custom">Crear Nuevo Usuario</a>
    </div>
    <div class="table-responsive">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Puesto</th>
                    <th>Edad</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->apellido }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->puesto }}</td>
                        <td>{{ $user->edad }}</td>
                        <td>{{ $user->telefono }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info view-password" data-id="{{ $user->id }}">Ver Contraseña</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para ingresar la contraseña del administrador -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Ver Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    @csrf
                    <input type="hidden" id="userId" name="user_id">
                    <div class="mb-3">
                        <label for="admin_password" class="form-label">Ingrese su contraseña de administrador:</label>
                        <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verificar</button>
                </form>
                <div id="passwordResult" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordModal = document.getElementById('passwordModal');
        const passwordForm = document.getElementById('passwordForm');
        const passwordResult = document.getElementById('passwordResult');
        let modalInstance = null;

        // Abrir el modal cuando se hace clic en "Ver Contraseña"
        document.querySelectorAll('.view-password').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const userId = this.getAttribute('data-id');
                document.getElementById('userId').value = userId;
                passwordResult.innerHTML = ''; // Limpiar resultados anteriores
                if(!modalInstance) {
                    modalInstance = new bootstrap.Modal(passwordModal);
                }
                modalInstance.show();
            });
        });

        // Enviar la solicitud para verificar la contraseña del administrador
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const userId = formData.get('user_id');

            fetch(`/users/${userId}/show-password`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    passwordResult.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                } else {
                    passwordResult.innerHTML = `<div class="alert alert-success">Contraseña: ${data.password}</div>`;
                }
            })
            .catch(error => {
                passwordResult.innerHTML = `<div class="alert alert-danger">Ocurrió un error al procesar la solicitud.</div>`;
            });
        });
    });
</script>
@endpush
@endsection
