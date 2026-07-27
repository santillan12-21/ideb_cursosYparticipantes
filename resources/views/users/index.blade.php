@extends('home')
@section('title', '- Lista de Usuarios')

@section('content')
<style>
    .users-container {
        padding: 40px 20px;
    }
    .table-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .table thead th {
        background-color: #212529 !important;
        color: white !important;
        padding: 15px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }
    
    /* Botones uniformes */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px !important;
        padding: 0 16px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
        height: 40px;
        min-width: 120px;
        margin: 2px;
        border: none;
        color: white !important;
        text-decoration: none !important;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        white-space: nowrap;
    }
    .btn-action:hover {
        transform: translateY(-1px);
        opacity: 0.92;
        color: white !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
    }
    .btn-action:focus-visible {
        outline: 2px solid rgba(13, 110, 253, 0.35);
        outline-offset: 2px;
    }
    .btn-action i {
        margin-right: 6px;
    }
    .btn-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .btn-info-modern { background-color: #17a2b8; }
    .btn-warning-modern { background-color: #ffc107; color: #212529 !important; }
    .btn-danger-modern { background-color: #dc3545; }
    .btn-success-modern { background-color: #28a745; }
    .btn-secondary-modern { background-color: #6c757d; }
    .btn-dark-modern { background-color: #212529; }

    .puesto-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
    }

    /* Sticky column for actions */
    .sticky-col { 
        position: sticky !important; 
        right: 0; 
        background-color: white !important; 
        z-index: 5; 
        box-shadow: -5px 0 10px rgba(0,0,0,0.05);
        min-width: 360px;
        width: 360px;
    }
    .table thead th.sticky-col {
        background-color: #212529 !important;
        z-index: 6;
    }
    tr:hover .sticky-col { background-color: #f8f9fa !important; }

    .actions-group {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .actions-group .btn-action {
        min-width: auto;
        padding: 0 12px;
        flex: 0 0 auto;
    }
    .actions-group form {
        display: inline-flex;
        margin: 0;
        padding: 0;
    }
</style>

<div class="container-fluid users-container">
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="h3 mb-0" style="font-weight: 300;">Gestión de Usuarios</h1>
            <div class="btn-toolbar">
                <a href="{{ route('users.create') }}" class="btn-action btn-success-modern">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
                <a href="{{ route('users.papelera') }}" class="btn-action btn-secondary-modern">
                    <i class="fas fa-trash-alt"></i> Papelera
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nombre Completo</th>
                        <th>Correo Electrónico</th>
                        <th>Puesto</th>
                        <th class="text-center">Edad</th>
                        <th class="text-center">Teléfono</th>
                        <th class="text-center sticky-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-center text-muted">#{{ $user->id }}</td>
                            <td class="fw-bold">{{ $user->name }} {{ $user->apellido }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="puesto-badge">{{ $user->puesto }}</span></td>
                            <td class="text-center">{{ $user->edad }}</td>
                            <td class="text-center">{{ $user->telefono }}</td>
                            <td class="sticky-col">
                                <div class="actions-group">
                                    <button type="button" class="btn-action btn-info-modern view-password" data-id="{{ $user->id }}" title="Ver Contraseña">
                                        <i class="fas fa-key"></i> Contraseña
                                    </button>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn-action btn-warning-modern" title="Editar">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Enviar usuario a la papelera?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-danger-modern" title="Eliminar">
                                            <i class="fas fa-trash"></i> Borrar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No se encontraron usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para ingresar la contraseña del administrador -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white border-0">
                <h5 class="modal-title" style="font-weight: 300;">Confirmación de Seguridad</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="passwordForm">
                    @csrf
                    <input type="hidden" id="userId" name="user_id">
                    <p class="text-muted small mb-4">Para visualizar la contraseña de este usuario, ingrese su contraseña de administrador/programador.</p>
                    <div class="mb-4">
                        <label for="admin_password" class="form-label fw-bold small text-muted">Contraseña Admin</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text bg-white border-0"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control border-0" id="admin_password" name="admin_password" required placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-action" style="height: 45px; border-radius: 6px;">
                        <i class="fas fa-shield-alt me-2"></i> Verificar y Mostrar
                    </button>
                </form>
                <div id="passwordResult" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordModalElement = document.getElementById('passwordModal');
        const passwordForm = document.getElementById('passwordForm');
        const passwordResult = document.getElementById('passwordResult');
        let modalInstance = null;

        // Abrir el modal cuando se hace clic en "Ver Contraseña"
        document.querySelectorAll('.view-password').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const userId = this.getAttribute('data-id');
                document.getElementById('userId').value = userId;
                document.getElementById('admin_password').value = '';
                passwordResult.innerHTML = '';
                
                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(passwordModalElement);
                }
                modalInstance.show();
            });
        });

        // Enviar la solicitud
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            passwordResult.innerHTML = '<div class="text-center py-2"><i class="fas fa-spinner fa-spin me-2"></i> Verificando...</div>';

            const formData = new FormData(this);
            const userId = document.getElementById('userId').value;
            const url = "{{ route('users.showPassword', ':id') }}".replace(':id', userId);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    passwordResult.innerHTML = `<div class="alert alert-danger border-0 shadow-sm small">${data.error}</div>`;
                } else {
                    passwordResult.innerHTML = `
                        <div class="alert alert-success border-0 shadow-sm">
                            <div class="small fw-bold mb-1">Contraseña recuperada:</div>
                            <div class="h5 mb-0 text-center font-monospace">${data.password}</div>
                        </div>`;
                }
            })
            .catch(error => {
                passwordResult.innerHTML = `<div class="alert alert-danger border-0 shadow-sm small">Error en la comunicación con el servidor.</div>`;
            });
        });
    });
</script>
@endpush
@endsection
