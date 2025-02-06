@extends('layouts.app')

@section('content')

<style>
    .table-container {
        width: 100%;
        overflow-x: auto; /* Permite desplazamiento horizontal si el contenido es demasiado ancho */
        margin: 0 auto; /* Centra el contenedor */
        padding: 130px;
        box-sizing: border-box;
    }

    table {
        width: 200%;
        max-width: 1500px; /* Limita el ancho máximo de la tabla */
        margin: 0 auto; /* Centra la tabla dentro del contenedor */
        border-collapse: collapse; /* Elimina los bordes adicionales entre celdas */
        text-align: center; /* Centra el texto dentro de las celdas */
    }


       /* Estilo para el contenedor del tooltip */
       .search-help {
            position: relative;
            display: inline-block;
            margin-left: 8px;
            color: #6c757d;
            cursor: help;
        }

        .search-help:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .tooltip-text {
            visibility: hidden;
            width: 300px;
            background-color: #333;
            color: #fff;
            text-align: left;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 14px;
            line-height: 1.4;
        }

        .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }
        .tooltip-text {
        z-index: 1000; /* Asegura que el tooltip esté encima de otros elementos */
    }

</style>

    <div class="container">
        <!-- Título de la sección -->
        <h3 class="text-center mt-5">Participantes Inscritos</h3>

        <!-- Botón para Mostrar/Ocultar Filtros -->
        <div class="text-center mb-4">
            <button id="toggleFilters" class="btn btn-primary">Mostrar/Ocultar Filtros</button>
        </div>

        <!-- Contenedor de Filtros (oculto inicialmente) -->
        <div id="filtersContainer" class="row mb-4" style="display: none;">
            <div class="col-md-12">
                <form action="{{ route('participantes.filtrar') }}" method="GET" class="form-inline">
                    <!-- Filtro por Curso -->
                    <div class="form-group mr-3">
                        <label for="curso" class="mr-2">Curso:</label>
                        <select name="curso" id="curso" class="form-control">
                            <option value="">Todos los Cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ request('curso') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->NombredelCurso }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Estado de Pago -->
                    <div class="form-group mr-3">
                        <label for="estado_pago" class="mr-2">Estado de Pago:</label>
                        <select name="estado_pago" id="estado_pago" class="form-control">
                            <option value="">Todos</option>
                            <option value="Pagado" {{ request('estado_pago') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="Pendiente" {{ request('estado_pago') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Anticipo" {{ request('estado_pago') == 'Anticipo' ? 'selected' : '' }}>Anticipo</option>
                            <option value="Cancelado" {{ request('estado_pago') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <!-- Filtro por Rango de Costo -->
                    <div class="form-group mr-3">
                        <label for="min_costo" class="mr-2">Costo Mínimo:</label>
                        <input type="text" name="min_costo" id="min_costo" class="form-control"
                            placeholder="Mínimo" value="{{ request('min_costo') }}">
                    </div>
                    <div class="form-group mr-3">
                        <label for="max_costo" class="mr-2">Costo Máximo:</label>
                        <input type="text" name="max_costo" id="max_costo" class="form-control"
                            placeholder="Máximo" value="{{ request('max_costo') }}">
                    </div>

                    <!-- Filtro de búsqueda -->
                    <div class="form-group mr-3 position-relative">
                        <label for="busqueda" class="mr-2">Búsqueda General:</label>
                        <div class="d-flex align-items-center">
                            <input type="text" name="busqueda" id="busqueda" class="form-control"
                                placeholder="Buscar por nombre, correo, teléfono, empresa..."
                                value="{{ request('busqueda') }}">
                                <div class="search-help ml-2">
                                    <i class="fas fa-question-circle text-primary" style="font-size: 1.2rem;"></i>
                                    <div class="tooltip-text">
                                        Puedes buscar toda la información de la tabla, a excepción de pago y cursos.
                                        Puedes usar mayúsculas y minúsculas.
                                        Para regresar a la tabla completa, solo borra lo que escribiste y dale clic a filtrar.
                                    </div>
                                </div>
                        </div>
                    </div>

                    <!-- Botón para Aplicar Filtros -->
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        </div>

        <!-- Botones de Exportación -->

        <a href="{{ route('exportar.excel') }}" class="btn btn-success">Exportar a Excel</a>
        <a href="{{ route('exportar.csv') }}" class="btn btn-primary">Exportar a CSV</a>

        <!-- Contenedor responsivo para la tabla -->
        <div class="table-container">
            <table id="participantesTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>N</th>
                        <th>Nombre del Postulante</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Edad</th>
                        <th>Dirección</th>
                        <th>Escolaridad</th>
                        <th>CURP</th>
                        <th>Razón Social</th>
                        <th>Empresa</th>
                        <th>RFC Empresa</th>
                        <th>Puesto</th>
                        <th>Pago</th>
                        <th>Estado de Pago</th>
                        <th>Fecha del Curso</th>
                        <th>Cursos Inscritos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participantes as $participante)
                    <tr>
                        <!-- Información del participante -->
                        <td>{{ $participante->N }}</td>
                        <td>{{ $participante->NombredelPostulante }}</td>
                        <td>{{ $participante->Correo }}</td>
                        <td>{{ $participante->Telefono }}</td>
                        <td>{{ $participante->Edad }}</td>
                        <td>{{ $participante->Direccion }}</td>
                        <td>{{ $participante->Escolaridad }}</td>
                        <td>{{ $participante->Curp }}</td>
                        <td>{{ $participante->RazónSocial }}</td>
                        <td>{{ $participante->Empresa }}</td>
                        <td>{{ $participante->RFCEmpresa }}</td>
                        <td>{{ $participante->Puesto }}</td>
                        <td>${{ number_format($participante->Pago, 2) }}</td>
                        <td>{{ $participante->EstadoDePago }}</td>
                        <td>{{ $participante->FechadelCurso }}</td>
                        <td>
                            @if($participante->cursos->isEmpty())
                                <span>No hay cursos inscritos</span>
                            @else
                                @foreach($participante->cursos as $curso)
                                    {{ $curso->NombredelCurso }} ({{ $curso->pivot->FechadelCurso }})<br/>
                                @endforeach
                            @endif
                        </td>
                        <!-- Acciones (Editar y Eliminar) -->
                        <td>
                            <a href="{{ route('participantes.detalles', ['id' => $participante->id]) }}" class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <!-- Botón Editar -->
                            <a href="{{ route('participantes.edit', ['id' => $participante->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <!-- Botón Eliminar -->
                            <form action="{{ route('participantes.destroy', ['id' => $participante->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este participante?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="16" class="text-center">No hay participantes inscritos con los filtros aplicados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
         </div>
    </div>

    <!-- Script para Mostrar/Ocultar Filtros -->
    <script>
    document.getElementById('toggleFilters').addEventListener('click', function() {
        var filtersContainer = document.getElementById('filtersContainer');
        if (filtersContainer.style.display === 'none') {
            filtersContainer.style.display = 'block';
        } else {
            filtersContainer.style.display = 'none';
        }
    });


    </script>

    <!-- DataTables y Exportación -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    <script>
    $(document).ready(function () {
        var table = $('#participantesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Exportar a Excel',
                    className: 'dt-button buttons-excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Exportar a PDF',
                    title: 'Lista de Cursos',
                    className: 'dt-button buttons-pdf',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 10;
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.pageMargins = [5, 5, 5, 5];
                        doc.content[1].table.pageBreak = 'auto';
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'Exportar a CSV',
                    className: 'dt-button buttons-csv',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ],
            initComplete: function () {
                $('.dt-buttons').hide();
                $('.dataTables_filter').append(
                    '<div class="search-help">' +
                        '<i class="fas fa-question-circle"></i>' +
                        '<div class="tooltip-text">' +
                            '<strong>Búsqueda rápida:</strong><br>' +
                            '• En todas las columnas<br>' +
                            '• Búsqueda instantánea<br>' +
                            '• Acepta múltiples términos<br>' +
                            '• No distingue mayúsculas<br>' +
                            '• Compatible con fechas' +
                        '</div>' +
                    '</div>'
                );
            }
        });

        // Asocia los botones personalizados con los botones de DataTables
        $('#exportExcel').on('click', function () {
            table.button('.buttons-excel').trigger();
        });

        $('#exportCSV').on('click', function () {
            table.button('.buttons-csv').trigger();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const helpIcon = document.querySelector('.search-help .fas.fa-question-circle');
    const tooltip = document.querySelector('.search-help .tooltip-text');

        if (helpIcon && tooltip) {
            helpIcon.addEventListener('mouseenter', () => {
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
            });

            helpIcon.addEventListener('mouseleave', () => {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            });
        }
    });
    </script>
@endsection
