@extends('layouts.app')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (con Popper.js incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<div class="container">
    <h1>Configuraciones</h1>

    <!-- Mostrar mensaje de éxito si existe -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Historial de Acciones -->
    <h2>Historial de Acciones</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Curso</th>
                <th>Acción</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Detalles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if ($logs->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No hay registros disponibles.</td>
                </tr>
            @else
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->nombre_curso }}</td>
                        <td>{{ $log->accion }}</td>
                        <td>{{ $log->user?->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->fecha_accion)->format('d/m/Y h:i A') }}</td>
                        <td>{{ $log->detalles }}</td>
                        <td>
                            @if ($log->curso)
                                <a href="{{ route('cursos.show', ['curso' => $log->curso->id]) }}" class="btn btn-info">
                                    Ver Detalles
                                </a>
                            @else
                                <span class="text-muted">Sin curso asociado</span>
                            @endif

                            <!-- Botones condicionales -->
                            @if ($log->accion === 'Eliminado' && isset($log->curso))
                                <!-- Botón para activar el curso nuevamente -->
                                <form action="{{ route('cursos.activar', ['id' => $log->curso->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Activar Curso</button>
                                </form>
                                <!-- Botón para Abrir el Modal -->
                                <!-- Botón para Abrir el Primer Modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#initialConfirmModal{{ $log->id }}">
                                    Eliminar Definitivamente
                                </button>

                                <!-- Primer Modal: Confirmación Inicial -->
                                <div class="modal fade" id="initialConfirmModal{{ $log->id }}" tabindex="-1" aria-labelledby="initialConfirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="initialConfirmModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas eliminar este curso definitivamente?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="openPasswordModal({{ $log->id }})">Sí, estoy seguro</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Segundo Modal: Ingreso de Contraseña -->
                                <div class="modal fade" id="confirmDeleteModal{{ $log->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Ingresa tu contraseña para confirmar la eliminación:</p>
                                                <form id="deleteForm{{ $log->id }}" action="{{ route('cursos.eliminar-definitivo', ['id' => $log->curso->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="mb-3">
                                                        <label for="password{{ $log->id }}" class="form-label">Contraseña:</label>
                                                        <input type="password" class="form-control" id="password{{ $log->id }}" name="password" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Configuración de Base de Datos -->
    <h2>Configuración de Base de Datos</h2>
    <form action="{{ route('configuraciones.guardar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="db_connection">Tipo de Conexión</label>
            <select name="db_connection" id="db_connection" class="form-control">
                <option value="mysql" {{ $currentDbConnection == 'mysql' ? 'selected' : '' }}>MySQL</option>
                <option value="pgsql" {{ $currentDbConnection == 'pgsql' ? 'selected' : '' }}>PostgreSQL</option>
                <option value="sqlite" {{ $currentDbConnection == 'sqlite' ? 'selected' : '' }}>SQLite</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>

    <!-- Exportar Cursos -->
    <div>
        <a href="{{ route('exportar.cursos') }}" class="btn btn-primary">
            Exportar Cursos
        </a>
    </div>
    <br>

    <!-- Exportar Participantes -->
    <div>
        <a href="{{ route('exportar.participantes') }}" class="btn btn-success">
            Exportar Participantes
        </a>
    </div>
    <br>

    <!-- Abrir Proyecto en VS Code -->
    <div>
        <a href="{{ route('abrir.vscode') }}" class="btn btn-info">
            Abrir Proyecto en VS Code
        </a>
    </div>

    <!-- Configuración del Logo -->
    <h2>Configuración del Logo</h2>
    <form action="{{ route('configuraciones.updateLogo') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="logo">Seleccionar Logo</label>
            <input type="file" name="logo" id="logo" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Logo</button>
    </form>

    <!-- Seleccionar Logo desde la Lista -->
    <h2>Seleccionar Logo desde la Lista</h2>
    <form action="{{ route('configuraciones.updateLogoFromList') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="selected_logo">Seleccionar Logo</label>
            <select name="selected_logo" id="selected_logo" class="form-control">
                @php
                    // Leer los archivos de la carpeta logos
                    $logos = glob(storage_path('app/public/logos/*.{jpg,jpeg,png,gif}'), GLOB_BRACE);
                    $logoNames = array_map(fn($path) => basename($path), $logos);
                @endphp
                @foreach ($logoNames as $logo)
                    <option value="{{ $logo }}" {{ $currentLogo && strpos($currentLogo, $logo) !== false ? 'selected' : '' }}>
                        {{ $logo }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Logo</button>
    </form>

    <!-- Mostrar el logo actual -->
    <h3>Logo Actual:</h3>
    @if ($currentLogo)
        <img src="{{ asset('storage/' . $currentLogo) }}" alt="Logo Actual" style="max-width: 200px;">
    @else
        <p>No hay un logo configurado.</p>
    @endif
</div>
<script>
    function openPasswordModal(logId) {
        // Cerrar el primer modal
        const initialModal = bootstrap.Modal.getInstance(document.getElementById(`initialConfirmModal${logId}`));
        if (initialModal) {
            initialModal.hide();
        }

        // Abrir el segundo modal
        const passwordModal = new bootstrap.Modal(document.getElementById(`confirmDeleteModal${logId}`));
        passwordModal.show();
    }
</script>

@endsection
