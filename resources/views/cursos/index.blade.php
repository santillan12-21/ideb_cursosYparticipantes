<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }

        .sidebar h5 {
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .sidebar .filter-section {
            padding: 10px 15px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        header {
            background-color: #000000;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-left: 250px;
            position: relative;
            transition: margin-left 0.3s ease-in-out; /* Transición suave */
        }

            header.expanded {
            margin-left: 0; /* Elimina el margen izquierdo cuando el filtro está oculto */
        }

        header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        nav {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        nav a, .logout-button {
            color: #fff;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }

        nav a:hover, .logout-button:hover {
            text-decoration: underline;
        }

        .logout-button {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .table-container {
            margin-top: 20px;
        }

        .drive-link a {
            color: blue;
            text-decoration: underline;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
        }

        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .content {
            margin-left: 250px; /* Margen izquierdo cuando el filtro está visible */
            padding: 20px;
            transition: margin-left 0.3s ease-in-out; /* Transición suave */
        }

        .content.expanded {
            margin-left: 0;
        }
        .custom-btn {
            background-color: #FF5733; /* Naranja */
            border-color: #FF5733;
            color: #FFFFFF;
        }

        .custom-btn:hover {
            background-color: #E74C3C; /* Naranja más oscuro */
            border-color: #E74C3C;
        }
        .button-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .button-container button {
            white-space: nowrap;
        }
        /* Centrar la tabla y el botón "Crear Nuevo Curso" */
        .table-container {
            max-width: 1200px; /* Ancho máximo del contenedor de la tabla */
            margin: 0 auto; /* Centrar el contenedor */
            padding: 20px;
        }

        #cursosTable {
        width: 100%; /* Ocupa el 100% del contenedor */
        max-width: 100%; /* Evita que la tabla sea demasiado ancha */
        table-layout: auto; /* Ajusta el ancho de las columnas automáticamente */
    }

    #toggleSidebar {
        background-color: #28a745; /* Color verde */
        border: none;
        padding: 10px 20px;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
        #toggleSidebar:hover {
        background-color: #218838; /* Color verde oscuro al pasar el mouse */
    }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h5>Filtros de Curso</h5>
        <div class="filter-section">
            <h6>Opciones de Visualización</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="viewOption" id="defaultView" value="default" checked>
                <label class="form-check-label" for="defaultView">
                    Vista Predeterminada
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="viewOption" id="driveView" value="drive">
                <label class="form-check-label" for="driveView">
                    Vista de Links Drive
                </label>
            </div>
        </div>

        <div class="filter-section">
            <h6>Filtros Adicionales</h6>
            <div class="mb-3">
                <label for="instructorFilter" class="form-label">Instructor</label>
                <select id="instructorFilter" class="form-select">
                    <option value="">Todos los Instructores</option>
                    @php
                        $instructores = $cursos->pluck('InstructorResponsable')->unique();
                    @endphp
                    @foreach($instructores as $instructor)
                        <option value="{{ $instructor }}">{{ $instructor }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="costoFilter" class="form-label">Rango de Costo</label>
                <div class="input-group">
                    <input type="number" id="costMinFilter" class="form-control" placeholder="Mínimo">
                    <input type="number" id="costMaxFilter" class="form-control" placeholder="Máximo">
                </div>
            </div>
        </div>
    </div>

    <header>
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
        <nav>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">Salir</button>
            </form>
            <a href="/Inicio">Inicio</a>
            <a href="{{ route('profile') }}">Mi Perfil</a>
        </nav>
        <div class="button-container">
            <button id="toggleSidebar" class="btn btn-success">Mostrar/Ocultar Filtros</button>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid table-container">
            <h2 class="text-center mb-4">Lista de Cursos</h2>

            <div class="mb-3">
                <button id="exportExcel" class="btn btn-success me-2">Exportar a Excel</button>
                <button id="exportCSV" class="btn btn-primary me-2">Exportar a CSV</button>
            </div>

            <table id="cursosTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nomenclatura de Curso</th>
                        <th>Nombre del Curso</th>
                        <th>Descripción</th>
                        <th>Duración del Curso</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Término</th>
                        <th>Costo</th>
                        <th>Instructor</th>
                        <th>Drive Sin Fecha</th>
                        <th>Drive Facebook</th>
                        <th>Drive LinkedIn</th>
                        <th>Drive Instagram</th>
                        <th>Drive Temario</th>
                        <th>Drive Itinerario</th>
                        <th>Drive Planeación</th>
                        <th>Drive Digital</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                        <tr>
                            <td>{{ $curso->Nomenclatura }}</td>
                            <td>{{ $curso->NombredelCurso }}</td>
                            <td>{{ $curso->DescripciondeCurso }}</td>
                            <td>{{ $curso->Duracioncurso }}</td>
                            <td>{{ \Carbon\Carbon::parse($curso->FechadeInicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($curso->FechadeTermino)->format('d/m/Y') }}</td>
                            <td>${{ number_format($curso->CostodelCurso, 2) }}</td>
                            <td>{{ $curso->InstructorResponsable }}</td>
                            <td class="drive-link">
                                @if($curso->DriveSinFecha)
                                    <a href="{{ $curso->DriveSinFecha }}" target="_blank">Drive Sin Fecha</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DriveFacebook)
                                    <a href="{{ $curso->DriveFacebook }}" target="_blank">Drive Facebook</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DriveLinkedin)
                                    <a href="{{ $curso->DriveLinkedin }}" target="_blank">Drive LinkedIn</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DriveInstagram)
                                    <a href="{{ $curso->DriveInstagram }}" target="_blank">Drive Instagram</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DriveTemario)
                                    <a href="{{ $curso->DriveTemario }}" target="_blank">Drive Temario</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DriveItinerario)
                                    <a href="{{ $curso->DriveItinerario }}" target="_blank">Drive Itinerario</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DrivePlaneación)
                                    <a href="{{ $curso->DrivePlaneación }}" target="_blank">Drive Planeación</a>
                                @endif
                            </td>
                            <td class="drive-link">
                                @if($curso->DriveDigital)
                                    <a href="{{ $curso->DriveDigital }}" target="_blank">Drive Digital</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-warning">Editar Curso</a>
                                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este curso?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('curso.paso1') }}" class="btn btn-success">Crear Nuevo Curso</a>
        </div>
    </div>

    <!-- Required scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
    var table = $('#cursosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        },
        columnDefs: [
            {
                targets: [8, 9, 10, 11, 12, 13, 14, 15], // Columnas de enlaces de Drive
                visible: false // Ocultar por defecto
            }
        ],
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
        }
    });

    // Toggle sidebar visibility
    $('#toggleSidebar').on('click', function() {
        $('.sidebar').toggleClass('hidden');
        $('.content').toggleClass('expanded');
        $('header').toggleClass('expanded');
    });

    // View Option Toggle
    $('input[name="viewOption"]').on('change', function() {
        var selectedView = $(this).val();

        if (selectedView === 'drive') {
            // Vista de enlaces de Drive: Mostrar solo el nombre del curso y los enlaces de Drive
            table.columns().every(function(index) {
                var column = this;
                if (index === 1 ||  // Nombre del Curso
                    (index >= 8 && index <= 15)  // Enlaces de Drive
                ) {
                    column.visible(true);
                } else {
                    column.visible(false);
                }
            });
        } else {
            // Vista predeterminada: Mostrar todas las columnas excepto los enlaces de Drive
            table.columns().every(function(index) {
                if (index >= 8 && index <= 15) {  // Enlaces de Drive
                    column.visible(false);
                } else {
                    column.visible(true);
                }
            });
        }

        table.draw();
    });

    // Instructor Filter
    $('#instructorFilter').on('change', function() {
        var instructor = $(this).val();
        table.column(7).search(instructor).draw(); // Ajusta el índice de la columna del instructor
    });

    // Cost Range Filter
    $('#costMinFilter, #costMaxFilter').on('keyup change', function() {
        var minCost = parseFloat($('#costMinFilter').val()) || 0;
        var maxCost = parseFloat($('#costMaxFilter').val()) || Number.MAX_VALUE;

        // Limpiar filtros anteriores
        $.fn.dataTable.ext.search.pop();

        $.fn.dataTable.ext.search.push(
            function(settings, data) {
                // Cambiar el índice de la columna de costo a 6
                var cost = parseFloat(data[6].replace('$', '').replace(',', '')) || 0;
                return (cost >= minCost && cost <= maxCost);
            }
        );
        table.draw();
    });

    // Export buttons
    $('#exportExcel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    $('#exportCSV').on('click', function() {
        table.button('.buttons-csv').trigger();
    });
});


    </script>
</body>
</html>
