@extends('home')
@section('title', '- Lista de Cursos')

@section('content')
<style>
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --success-color: #198754;
        --dark-color: #212529;
        --danger-color: #dc3545;
    }
    .container-fluid { padding: 20px; }
    .table-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    
    /* Tamaño de letra uniforme */
    .table thead th { 
        background-color: var(--dark-color) !important; color: white !important; 
        padding: 15px; font-weight: 600; white-space: nowrap; font-size: 0.9rem; 
    }
    .table td { padding: 12px 15px; white-space: nowrap; font-size: 0.9rem; border-bottom: 1px solid #f1f3f5; }
    
    /* Columna Acciones Fija */
    .sticky-col {
        position: sticky !important;
        right: 0;
        background-color: white !important;
        z-index: 5;
        box-shadow: -5px 0 10px rgba(0,0,0,0.05);
    }
    th.sticky-col { background-color: var(--dark-color) !important; z-index: 6; }
    
    .btn-expand { background: none; border: none; color: var(--primary-color); font-size: 1.1rem; cursor: pointer; transition: transform 0.2s; padding: 0; margin-right: 5px; }
    .btn-expand.active { transform: rotate(45deg); color: #dc3545; }
    
    .status-badge { font-size: 0.75rem; padding: 0.4em 0.8em; border-radius: 20px; }
    .action-btns .btn { margin-right: 2px; border-radius: 8px; padding: 0.35rem 0.5rem; font-size: 0.75rem; }
    
    /* Sección Subcursos */
    .expanded-section { background-color: #f8faff; border-left: 4px solid var(--primary-color); padding: 20px; }
    .subcourse-header { margin-bottom: 15px; }
    .subcourse-table-container { 
        background: white; border-radius: 10px; border: 1px solid #dee2e6; 
        overflow-x: auto; position: relative;
    }
    
    /* Sticky Acciones Subcursos */
    .sub-sticky-col {
        position: sticky !important;
        right: 0;
        background-color: #ffffff !important;
        z-index: 5;
        box-shadow: -5px 0 10px rgba(0,0,0,0.05);
        border-left: 1px solid #dee2e6;
    }
    th.sub-sticky-col { background-color: #e9ecef !important; z-index: 6; }
    
    .pagination .page-link { color: var(--dark-color); }
    .pagination .active .page-link { background-color: var(--dark-color); border-color: var(--dark-color); color: white; }
</style>

<div class="container-fluid">
    <div class="table-container">
        <!-- Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <h1 class="h3 mb-0 fw-bold">Gestión de Cursos</h1>
            </div>
            <div class="col-md-8 text-end">
                <div class="d-flex justify-content-end gap-2">
                    <form action="{{ route('cursos.index') }}" method="GET" class="d-flex me-3">
                        <div class="input-group shadow-sm">
                            <input type="text" name="search" class="form-control" placeholder="Buscar curso..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <a href="{{ route('exportar.cursos.excel') }}" class="btn btn-outline-success"><i class="fas fa-file-excel me-1"></i> Excel</a>
                    <a href="{{ route('exportar.cursos.csv') }}" class="btn btn-outline-info"><i class="fas fa-file-csv me-1"></i> CSV</a>
                    <a href="{{ route('curso.iniciar') }}" class="btn btn-success fw-bold"><i class="fas fa-plus me-1"></i> Nuevo Curso</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabla Principal (7 campos originales) -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nomenclatura</th>
                        <th>Nombre del Curso</th>
                        <th>Descripción</th>
                        <th>Duración</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Término</th>
                        <th class="text-center sticky-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr id="row-{{ $curso->id }}">
                            <td class="fw-bold">
                                <button class="btn-expand" onclick="toggleDetails({{ $curso->id }})">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <span class="text-primary">{{ $curso->nomenclatura }}</span>
                            </td>
                            <td class="fw-bold">{{ $curso->nombre }}</td>
                            <td title="{{ $curso->descripcion }}">{{ \Illuminate\Support\Str::limit($curso->descripcion, 40) }}</td>
                            <td>{{ $curso->duracion }}</td>
                            <td>{{ $curso->fecha_inicio ? \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $curso->fecha_termino ? \Carbon\Carbon::parse($curso->fecha_termino)->format('d/m/Y') : '-' }}</td>
                            <td class="text-center sticky-col">
                                <div class="action-btns">
                                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-info text-white" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-warning {{ $curso->status != 1 ? 'disabled' : '' }}" title="Editar"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('cursos.toggle-status', $curso->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $curso->status == 1 ? 'btn-success' : 'btn-secondary' }}"><i class="fas fa-power-off"></i></button>
                                    </form>
                                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿A papelera?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Sección Subcursos -->
                        <tr id="details-{{ $curso->id }}" style="display: none;">
                            <td colspan="7" class="p-0">
                                <div class="expanded-section">
                                    <div class="subcourse-header">
                                        <h6 class="fw-bold text-dark mb-1">Gestión de Subcursos</h6>
                                        <a href="{{ route('subcursos.iniciar', $curso->id) }}" class="btn btn-sm btn-primary {{ $curso->status != 1 ? 'disabled' : '' }} mb-3">
                                            <i class="fas fa-plus me-1"></i> Agregar Subcurso
                                        </a>
                                    </div>
                                    <div class="subcourse-table-container">
                                        <div id="sub-list-{{ $curso->id }}">
                                            <div class="text-center py-4 text-muted">Cargando subcursos...</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted">No se encontraron registros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">Mostrando {{ $cursos->firstItem() ?: 0 }} a {{ $cursos->lastItem() ?: 0 }} de {{ $cursos->total() }} registros</div>
            {{ $cursos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const row = document.getElementById(`details-${id}`);
        const btn = document.querySelector(`#row-${id} .btn-expand`);
        const icon = btn.querySelector('i');
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
            btn.classList.add('active');
            icon.classList.replace('fa-plus-circle', 'fa-minus-circle');
            loadSubcourses(id);
        } else {
            row.style.display = 'none';
            btn.classList.remove('active');
            icon.classList.replace('fa-minus-circle', 'fa-plus-circle');
        }
    }

    function loadSubcourses(parentId) {
        const container = document.getElementById(`sub-list-${parentId}`);
        fetch(`/cursos/subcursos/${parentId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    let html = `<table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nomenclatura</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Duración</th>
                                <th>Inicio</th>
                                <th>Término</th>
                                <th>Instructor</th>
                                <th>Costo</th>
                                <th>Modalidad</th>
                                <th>Estatus</th>
                                <th class="text-center sub-sticky-col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    data.forEach(sub => {
                        const sBadge = sub.status == 1 ? 'bg-success' : 'bg-secondary';
                        const sText = sub.status == 1 ? 'Activo' : 'Suspendido';
                        const tBtn = sub.status == 1 ? 'btn-success' : 'btn-secondary';
                        html += `<tr>
                            <td class="ps-3 fw-bold text-primary">${sub.nomenclatura}</td>
                            <td class="fw-bold">${sub.nombre}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>${sub.instructor || '-'}</td>
                            <td class="fw-bold text-success">$${sub.costo}</td>
                            <td><span class="badge bg-white text-dark border">${sub.modalidad}</span></td>
                            <td><span class="badge ${sBadge}">${sText}</span></td>
                            <td class="text-center sub-sticky-col">
                                <div class="action-btns">
                                    <a href="/cursos/${sub.id}" class="btn btn-xs btn-info text-white"><i class="fas fa-eye"></i></a>
                                    <a href="/cursos/${sub.id}/edit" class="btn btn-xs btn-warning ${sub.status != 1 ? 'disabled' : ''}"><i class="fas fa-edit"></i></a>
                                    <form action="/cursos/${sub.id}/toggle-status" method="POST" style="display:inline;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn btn-xs ${tBtn}"><i class="fas fa-power-off"></i></button>
                                    </form>
                                    <form action="/cursos/${sub.id}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar?')">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>`;
                    });
                    html += `</tbody></table>`;
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<div class="p-4 text-center text-muted">Sin subcursos.</div>';
                }
            });
    }
</script>
@endsection
