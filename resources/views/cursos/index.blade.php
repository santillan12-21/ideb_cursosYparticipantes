@extends('home')
@section('title', '- Lista de Cursos')

@section('content')
<!-- DataTables & Extra CSS -->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">

<style>
    .container-fluid {
        padding: 20px;
    }
    .table-container {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .table {
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .table thead th {
        background-color: #212529 !important;
        color: white !important;
        border: none;
        padding: 15px;
    }
    .table tbody tr {
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
        border: none !important;
    }
    /* Estilo para Subcursos (Efecto Carpeta) */
    .subcourse-row {
        background-color: #f8faff !important;
        display: none; /* Ocultos por defecto */
    }
    .subcourse-indent {
        padding-left: 40px !important;
        position: relative;
    }
    .subcourse-indent::before {
        content: '└─';
        position: absolute;
        left: 15px;
        color: #0d6efd;
        font-weight: bold;
    }
    .btn-folder {
        background: none;
        border: none;
        color: #0d6efd;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        margin-right: 10px;
    }
    .badge-sub {
        background-color: #e7f1ff;
        color: #0d6efd;
        border: 1px solid #0d6efd;
        font-size: 0.7rem;
        text-transform: uppercase;
    }
</style>

<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-folder-open me-2 text-primary"></i>Lista de Cursos</h1>
            <div>
                <a href="{{ route('cursos.papelera') }}" class="btn btn-secondary shadow-sm me-2">
                    <i class="fas fa-trash-alt me-1"></i> Papelera
                </a>
                <a href="{{ route('curso.iniciar') }}" class="btn btn-success shadow-sm">
                    <i class="fas fa-plus me-1"></i> Nuevo Curso
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="cursosTable" class="table">
                <thead>
                    <tr>
                        <th>Nomenclatura</th>
                        <th>Nombre del Curso</th>
                        <th>Instructor</th>
                        <th>Costo</th>
                        <th>Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                        <tr class="parent-row" data-id="{{ $curso->id }}">
                            <td class="fw-bold">
                                <button class="btn-folder toggle-hierarchy" data-id="{{ $curso->id }}">
                                    <i class="fas fa-folder"></i>
                                </button>
                                {{ $curso->Nomenclatura }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $curso->NombredelCurso }}</div>
                            </td>
                            <td>{{ $curso->InstructorResponsable }}</td>
                            <td class="text-success fw-bold">${{ number_format((float)$curso->CostodelCurso, 2) }}</td>
                            <td>
                                <span class="badge {{ $curso->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $curso->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-outline-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-outline-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('subcursos.iniciar', $curso->id) }}" class="btn btn-sm btn-outline-primary" title="Añadir Subcurso"><i class="fas fa-plus"></i></a>
                                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Desactivar"><i class="fas fa-power-off"></i></button>
                                    </form>
                                    <form action="{{ route('cursos.eliminar-definitivo', ['id' => $curso->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Borrar definitivamente?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Aquí se inyectarán los subcursos dinámicamente -->
                        <tr id="sub-container-{{ $curso->id }}" class="subcourse-row">
                            <td colspan="6" class="p-0">
                                <div id="sub-list-{{ $curso->id }}">
                                    <!-- Cargando... -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.toggle-hierarchy').on('click', function() {
            const id = $(this).data('id');
            const row = $(`#sub-container-${id}`);
            const icon = $(this).find('i');

            if (row.is(':visible')) {
                row.hide();
                icon.removeClass('fa-folder-open').addClass('fa-folder');
            } else {
                row.show();
                icon.removeClass('fa-folder').addClass('fa-folder-open');
                loadSubcoursesInTable(id);
            }
        });

        function loadSubcoursesInTable(parentId) {
            const container = $(`#sub-list-${parentId}`);
            container.html('<div class="text-center py-2"><i class="fas fa-spinner fa-spin"></i> Cargando subcursos...</div>');

            $.get(`/cursos/subcursos/${parentId}`, function(data) {
                if (data.length > 0) {
                    let html = '<table class="table mb-0 w-100" style="background-color: #f1f4f9;">';
                    data.forEach(sub => {
                        // Usar los nombres de propiedad correctos del modelo (PascalCase por los accessors)
                        const nomenclatura = sub.Nomenclatura || sub.nomenclatura || 'N/A';
                        const nombre = sub.NombredelCurso || sub.nombre || 'Sin nombre';
                        const instructor = sub.InstructorResponsable || sub.instructor_responsable || '-';
                        const costo = sub.CostodelCurso || sub.costo || '0';
                        const status = sub.status == 1 ? 'Activo' : 'Inactivo';
                        const badgeClass = sub.status == 1 ? 'bg-success' : 'bg-danger';

                        html += `
                        <tr class="border-bottom">
                            <td style="width: 50px"></td>
                            <td class="subcourse-indent fw-bold text-muted">${nomenclatura} <span class="badge badge-sub ms-2">Sub</span></td>
                            <td class="text-muted">${nombre}</td>
                            <td class="text-muted">${instructor}</td>
                            <td class="text-muted">$${parseFloat(costo).toLocaleString()}</td>
                            <td><span class="badge ${badgeClass} opacity-75">${status}</span></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="/cursos/${sub.id}" class="btn btn-xs btn-outline-info" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="/cursos/${sub.id}/edit" class="btn btn-xs btn-outline-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>`;
                    });
                    html += '</table>';
                    container.html(html);
                } else {
                    container.html('<div class="text-center text-muted small py-2">No se encontraron subcursos para este registro.</div>');
                }
            }).fail(function() {
                container.html('<div class="text-danger small py-2 text-center">Error al conectar con el servidor.</div>');
            });
        }
    });
</script>
@endpush
@endsection
