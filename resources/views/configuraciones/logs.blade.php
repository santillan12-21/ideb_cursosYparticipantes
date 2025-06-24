@extends('home')
@section('title', '- Configuraciones')
@section('nav')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logoibeb.ico') }}">

@section('content')
<!-- Bootstrap CSS -->

<!-- Bootstrap JS (con Popper.js incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<style>
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    h2 {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

   
  .btn {
    color: white;
    border: none;
        justify-content: center; /* Centra horizontalmente */
    align-items: center;     /* Centra verticalmente (si tiene altura definida) */

    border-radius: 5px;         /* Bordes un poco más rectos */
    padding: 4px 12px;          /* Más pequeño que 8px 20px */
    font-size: 13px;            /* Letra más pequeña */
    font-weight: 600;
    transition: background-color 0.3s ease, transform 0.2s;
    margin-top: 5px; /* Espacio entre botones */
    margin: 0 4px;  /* margen izquierdo y derecho de 4px para separación horizontal */
}


.btn-success {
    background: linear-gradient(135deg, #28a745, #43d967); /* Verde brillante con gradiente */
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px; /* Espacio entre botones */
    box-shadow: 0 0 12px rgba(67, 217, 103, 0.6); /* Brillo externo */
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #34b15d, #50e176);
    box-shadow: 0 0 18px rgba(67, 217, 103, 0.8);
    transform: scale(1.05);
}

.btn-success:active {
    transform: scale(0.97);
    box-shadow: 0 0 8px rgba(67, 217, 103, 0.5);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545, #ff4d4d); /* Rojo intenso con degradado */
    color: white;
            margin-top: 5px; /* Espacio entre botones */

    border: none;
    border-radius: 6px;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: bold;
    box-shadow: 0 0 10px rgba(255, 77, 77, 0.5); /* Efecto brillante */
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #ff1a1a);
    box-shadow: 0 0 15px rgba(255, 50, 50, 0.8);
    transform: scale(1.05);
}

.btn-danger:active {
    transform: scale(0.97);
    box-shadow: 0 0 8px rgba(255, 0, 0, 0.6);
}


/*Boton de eliminar  o desactivar*/

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #ffdd57); /* Amarillo con gradiente */
    color: black;
            margin-top: 5px; /* Espacio entre botones */

    border: none;
    border-radius: 6px;
    padding: 6px 18px;
    font-size: 13px;
    font-weight: bold;
    box-shadow: 0 0 10px rgba(255, 193, 7, 0.5); /* Brillo suave */
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e0a800, #ffd633);
    box-shadow: 0 0 14px rgba(255, 200, 0, 0.7);
    transform: scale(1.05);
}

.btn-warning:active {
    transform: scale(0.97);
    box-shadow: 0 0 6px rgba(255, 180, 0, 0.6);
}

/* Boton de ver detalles*/
.btn-info {
    background: linear-gradient(135deg, #17a2b8, #4dd0e1); /* Azul claro con gradiente */
    color: white;
            margin-top: 5px; /* Espacio entre botones */

    border: none;
    border-radius: 6px;
    padding: 7px 18px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 0 10px rgba(77, 208, 225, 0.6); /* Brillo suave */
    transition: all 0.3s ease;
    text-decoration: none; /* Para links sin subrayado */
    display: inline-block;
}

.btn-info:hover {
    background: linear-gradient(135deg, #138496, #36c1d7);
    box-shadow: 0 0 16px rgba(54, 193, 215, 0.9);
    transform: scale(1.05);
    text-decoration: none;
}

.btn-info:active {
    transform: scale(0.97);
    box-shadow: 0 0 8px rgba(54, 193, 215, 0.7);
}

/* Exportar cursos*/
.btn-primary {
    background: linear-gradient(135deg, #0056b3, #007bff); /* Azul fuerte con degradado */
    color: white;
            margin-top: 5px; /* Espacio entre botones */

    border: none;
    border-radius: 6px;
    padding: 8px 22px;
    font-size: 15px;
    font-weight: 700;
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.7); /* Brillo destacado */
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #004494, #339cff);
    box-shadow: 0 0 20px rgba(51, 156, 255, 0.9);
    transform: scale(1.05);
    text-decoration: none;
}

.btn-primary:active {
    transform: scale(0.97);
    box-shadow: 0 0 10px rgba(0, 90, 190, 0.8);
}
</style>
<div class="container">
    <h1>Configuraciones</h1>

    <!-- Mostrar mensaje de éxito si existe -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

   
<h2>Historial de Acciones de cursos</h2>
<a href="/configuraciones" class="btn btn-success" style="align-content: center; margin-top:-1%;">Ver todas las acciones</a>

<br>
<br>
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
                            <span class="text-muted">El curso fue eliminado</span>
                        @endif

                        @php
                            $accion = strtolower($log->accion);
                            $status = $log->curso ? (int)$log->curso->status : null;
                        @endphp

                        @if (($accion === 'eliminado' || $accion === 'finalizado') && $log->curso)
                            @if ($status === 0)
                                <!-- Curso desactivado: Botón Activar -->
                                <form action="{{ route('cursos.activar', ['id' => $log->curso->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Activar Curso</button>
                                </form>

                                <!-- Botón para abrir modal de eliminación definitiva -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#initialConfirmModal{{ $log->id }}">
                                    Eliminar Definitivamente
                                </button>

                                <!-- Modal Confirmación -->
                                <div class="modal fade" id="initialConfirmModal{{ $log->id }}" tabindex="-1" aria-labelledby="initialConfirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar este curso definitivamente?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="openPasswordModal({{ $log->id }})">
                                                    Sí, estoy seguro
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Ingreso de Contraseña -->
                                <div class="modal fade" id="confirmDeleteModal{{ $log->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Eliminar Curso Definitivamente</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="deleteForm{{ $log->id }}" action="{{ route('cursos.eliminar-definitivo', ['id' => $log->curso->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="mb-3">
                                                        <label>Contraseña:</label>
                                                        <input type="password" name="password" class="form-control" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($status === 1)
                                <!-- Curso activo: botón para desactivar -->
                                <form action="{{ route('cursos.desactivar', ['id' => $log->curso->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Eliminar Curso (Desactivar)</button>
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script>
    function openPasswordModal(id) {
        const modalId = `#confirmDeleteModal${id}`;
        const modal = new bootstrap.Modal(document.querySelector(modalId));
        modal.show();
    }
</script>



  
 

   

  

    

  

  



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
