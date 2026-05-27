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
    .info-label { font-weight: bold; color: #555; }
</style>

<div class="container-fluid">
    <div class="table-container">
        <!-- Header con Búsqueda y Acciones -->
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
                    <a href="{{ route('cursos.papelera') }}" class="btn btn-secondary shadow-sm"><i class="fas fa-trash-alt"></i> Papelera</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabla Principal -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;"></th>
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
                            <td class="text-center">
                                <button class="btn-expand" onclick="toggleDetails({{ $curso->id }})">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </td>
                            <td class="fw-bold">
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
                                    
                                    @if($curso->status == 1)
                                        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                    @else
                                        <button class="btn btn-sm btn-warning disabled" title="Curso desactivado"><i class="fas fa-edit"></i></button>
                                    @endif

                                    <form action="{{ route('cursos.toggle-status', $curso->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $curso->status == 1 ? 'btn-success' : 'btn-secondary' }}" title="{{ $curso->status == 1 ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Enviar curso a la papelera?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Fila Desplegable -->
                        <tr id="details-{{ $curso->id }}" style="display: none;">
                            <td colspan="8" class="p-0">
                                <div class="expanded-section">
                                    <div class="row">
                                        <div class="col-md-5 border-end">
                                            <h5 class="mb-3 text-primary">Información Adicional</h5>
                                            <div class="mb-2"><span class="info-label">Descripción:</span> <p class="mb-1 text-wrap" style="max-width: 100%">{{ $curso->descripcion }}</p></div>
                                            <div class="mb-2"><span class="info-label">Instructor:</span> {{ $curso->instructor_responsable }}</div>
                                            <div class="mb-2"><span class="info-label">Costo:</span> <span class="text-success fw-bold">${{ number_format((float)$curso->costo, 2) }}</span></div>
                                            <div class="mb-2">
                                                <span class="info-label">Estatus:</span>
                                                <span class="badge status-badge {{ $curso->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $curso->status == 1 ? 'Activo' : 'Desactivado' }}
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="info-label">Modalidad:</span>
                                                @if($curso->virtual == 'Sí') <span class="badge bg-primary">Virtual</span> @endif
                                                @if($curso->presencial == 'Sí') <span class="badge bg-secondary">Presencial</span> @endif
                                                @if($curso->mixto == 'Sí') <span class="badge bg-info">Mixto</span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-7 ps-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 text-primary">Subcursos Relacionados</h5>
                                                @if($curso->status == 1)
                                                    <a href="{{ route('subcursos.iniciar', $curso->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-plus me-1"></i> Agregar Subcurso
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-primary disabled"><i class="fas fa-plus me-1"></i> Agregar Subcurso</button>
                                                @endif
                                            </div>
                                            <div class="subcourse-table-container">
                                                <div id="sub-list-{{ $curso->id }}" class="subcourse-table">
                                                    <div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Cargando subcursos...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No se encontraron cursos que coincidan con la búsqueda.</td>
                        </tr>
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
