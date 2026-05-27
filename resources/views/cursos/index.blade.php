@extends('home')
@section('title', '- Lista de Cursos')

@section('content')
<style>
    .container-fluid { padding: 20px; }
    .table-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .table thead th { background-color: #212529 !important; color: white !important; padding: 15px; }
    .table td { vertical-align: middle; }
    .btn-expand { background: none; border: none; color: #0d6efd; font-size: 1.2rem; cursor: pointer; transition: transform 0.2s; }
    .btn-expand.active { transform: rotate(45deg); color: #dc3545; }
    .status-badge { font-size: 0.85rem; padding: 0.4em 0.8em; }
    .expanded-section { background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 20px; }
    /* Botones uniformes */
    .btn-action-curso {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
        height: 34px;
        min-width: 40px;
        margin: 2px;
        border: none;
        color: white !important;
    }
    .btn-action-curso:hover { transform: translateY(-1px); opacity: 0.9; }

    .btn-info-c { background-color: #17a2b8; }
    .btn-warning-c { background-color: #ffc107; color: #212529 !important; }
    .btn-success-c { background-color: #28a745; }
    .btn-secondary-c { background-color: #6c757d; }
    .btn-danger-c { background-color: #dc3545; }
</style>

<div class="container-fluid">
    <div class="table-container">
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <h1 class="h3 mb-0" style="font-weight: 300;">Gestión de Cursos</h1>
            </div>
            <div class="col-md-8 text-end">
                <div class="d-flex justify-content-end gap-2 flex-wrap">
                    <form action="{{ route('cursos.index') }}" method="GET" class="d-flex me-2">
                        <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <input type="text" name="search" class="form-control border-0" placeholder="Buscar curso..." value="{{ request('search') }}" style="height: 40px;">
                            <button type="submit" class="btn btn-dark" style="border-radius: 0; margin: 0; height: 40px; min-width: 50px;"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <a href="{{ route('exportar.cursos.excel') }}" class="btn btn-success" style="height: 40px; min-width: 110px;"><i class="fas fa-file-excel me-1"></i> Excel</a>
                    <a href="{{ route('exportar.cursos.csv') }}" class="btn btn-info" style="height: 40px; min-width: 110px;"><i class="fas fa-file-csv me-1"></i> CSV</a>
                    <a href="{{ route('curso.iniciar') }}" class="btn btn-primary" style="height: 40px; min-width: 110px;"><i class="fas fa-plus me-1"></i> Nuevo</a>
                    <a href="{{ route('cursos.papelera') }}" class="btn btn-secondary" style="height: 40px; min-width: 110px;"><i class="fas fa-trash-alt me-1"></i> Papelera</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;"></th>
                        <th>Nomenclatura</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Duración</th>
                        <th>Inicio</th>
                        <th>Término</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr id="row-{{ $curso->id }}">
                            <td class="text-center">
                                <button class="btn-expand" onclick="toggleDetails({{ $curso->id }})">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </td>
                            <td class="fw-bold text-primary">{{ $curso->nomenclatura }}</td>
                            <td>{{ $curso->nombre }}</td>
                            <td title="{{ $curso->descripcion }}">{{ \Illuminate\Support\Str::limit($curso->descripcion, 50) }}</td>
                            <td>{{ $curso->duracion }}</td>
                            <td class="small">{{ $curso->fecha_inicio ? \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') : '-' }}</td>
                            <td class="small">{{ $curso->fecha_termino ? \Carbon\Carbon::parse($curso->fecha_termino)->format('d/m/Y') : '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn-action-curso btn-info-c" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn-action-curso btn-warning-c {{ $curso->status != 1 ? 'disabled' : '' }}" title="Editar"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('cursos.toggle-status', $curso->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-curso {{ $curso->status == 1 ? 'btn-success-c' : 'btn-secondary-c' }}" title="{{ $curso->status == 1 ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" onsubmit="return confirm('¿Enviar curso a la papelera?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action-curso btn-danger-c" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr id="details-{{ $curso->id }}" style="display: none;">
                            <td colspan="8" class="p-0">
                                <div class="expanded-section">
                                    <div class="row">
                                        <div class="col-md-5 border-end">
                                            <h5 class="mb-3 text-primary">Información Adicional</h5>
                                            <p><span class="info-label">Descripción:</span> {{ $curso->descripcion }}</p>
                                            <p><span class="info-label">Instructor:</span> {{ $curso->instructor_responsable }}</p>
                                            <p><span class="info-label">Costo:</span> <span class="text-success fw-bold">${{ number_format((float)$curso->costo, 2) }}</span></p>
                                            <p><span class="info-label">Estatus:</span> 
                                                <span class="badge {{ $curso->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $curso->status == 1 ? 'Activo' : 'Desactivado' }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-7 ps-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-primary">Subcursos Relacionados</h5>
                                                <a href="{{ route('subcursos.iniciar', $curso->id) }}" class="btn btn-sm btn-primary {{ $curso->status != 1 ? 'disabled' : '' }}">
                                                    <i class="fas fa-plus"></i> Agregar
                                                </a>
                                            </div>
                                            <div id="sub-list-{{ $curso->id }}">
                                                <div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4">No se encontraron cursos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $cursos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const detailsRow = document.getElementById(`details-${id}`);
        const button = document.querySelector(`#row-${id} .btn-expand`);
        const icon = button.querySelector('i');
        if (detailsRow.style.display === 'none') {
            detailsRow.style.display = 'table-row';
            button.classList.add('active');
            icon.classList.replace('fa-plus-circle', 'fa-minus-circle');
            loadSubcourses(id);
        } else {
            detailsRow.style.display = 'none';
            button.classList.remove('active');
            icon.classList.replace('fa-minus-circle', 'fa-plus-circle');
        }
    }

    function loadSubcourses(parentId) {
        const container = document.getElementById(`sub-list-${parentId}`);
        fetch(`/cursos/subcursos/${parentId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    let html = `<table class="table table-sm"><thead><tr><th>Nomenclatura</th><th>Nombre</th><th>Acciones</th></tr></thead><tbody>`;
                    data.forEach(sub => {
                        html += `<tr>
                            <td>${sub.nomenclatura || ''}</td>
                            <td>${sub.nombre}</td>
                            <td>
                                <a href="/cursos/${sub.id}" class="btn btn-xs btn-info text-white"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>`;
                    });
                    html += `</tbody></table>`;
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<div class="text-muted small">No hay subcursos.</div>';
                }
            });
    }
</script>
@endsection


<script>
    function toggleDetails(id) {
        const detailsRow = document.getElementById(`details-${id}`);
        const button = document.querySelector(`#row-${id} .btn-expand`);
        const icon = button.querySelector('i');

        if (detailsRow.style.display === 'none') {
            detailsRow.style.display = 'table-row';
            button.classList.add('active');
            icon.classList.replace('fa-plus-circle', 'fa-minus-circle');
            loadSubcourses(id);
        } else {
            detailsRow.style.display = 'none';
            button.classList.remove('active');
            icon.classList.replace('fa-minus-circle', 'fa-plus-circle');
        }
    }

    function loadSubcourses(parentId) {
        const container = document.getElementById(`sub-list-${parentId}`);
        
        fetch(`/cursos/subcursos/${parentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let html = `<table class="table table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nomenclatura</th>
                                            <th>Nombre</th>
                                            <th>Estatus</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                    data.forEach(sub => {
                        const statusBadge = sub.status == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Desactivado</span>';
                        html += `<tr>
                                    <td class="fw-bold text-primary">${sub.nomenclatura || 'N/A'}</td>
                                    <td>${sub.nombre}</td>
                                    <td>${statusBadge}</td>
                                    <td class="text-center">
                                        <a href="/cursos/${sub.id}" class="btn btn-xs btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        ${sub.status == 1 ? `<a href="/cursos/${sub.id}/edit" class="btn btn-xs btn-outline-warning"><i class="fas fa-edit"></i></a>` : ''}
                                    </td>
                                 </tr>`;
                    });
                    html += `</tbody></table>`;
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<div class="text-center py-3 text-muted small">No hay subcursos registrados.</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = '<div class="text-danger py-3 small text-center">Error al cargar subcursos.</div>';
            });
    }
</script>
@endsection
