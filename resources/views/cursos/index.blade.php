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

        header {
            background-color: #000000;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }

        header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        nav {
            display: flex;
            align-items: center;
            margin-left: auto; /* Alinea los enlaces a la derecha */
        }

        nav a {
            color: #fff;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-button {
            color: #fff;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .logout-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
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
    </header>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Lista de Cursos</h2>

        <!-- Botones personalizados para exportar -->
        <div class="mb-3">
            <button id="exportExcel" class="btn btn-success me-2">Exportar a Excel</button>
            <button id="exportPDF" class="btn btn-danger">Exportar a PDF</button>
            <button id="exportCSV" class="btn btn-primary me-2">Exportar a CSV</button>
        </div>

        <table id="cursosTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nomenclatura de Curso</th>
                    <th>Nombre del Curso</th>
                    <th>Descripción</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Término</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $curso->Nomenclatura }}</td>
                        <td>{{ $curso->NombredelCurso }}</td>
                        <td>{{ $curso->DescripciondeCurso }}</td>
                        <td>{{ \Carbon\Carbon::parse($curso->FechadeInicio)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($curso->FechadeTermino)->format('d/m/Y') }}</td>
                        <td>${{ number_format($curso->CostodelCurso, 2) }}</td>
                        <td><a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-warning">Editar Curso</a>
                            <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este curso?')">Eliminar</button>
                            </form>
                        </td>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('curso.paso1') }}" class="btn btn-success">Crear Nuevo Curso</a>
    </div>

    <!-- Required scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables scripts -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

    <!-- JSZip and pdfMake for Excel and PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- DataTables HTML5 export buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    <!-- Initialize DataTable -->
    <script type="text/javascript">
       $(document).ready(function() {
           var table = $('#cursosTable').DataTable({
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
                            columns: ':not(:last-child)' // Excluir la columna "Acciones"
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar a PDF',
                        title: 'Lista de Participantes',
                        className: 'dt-button buttons-pdf',
                        orientation: 'landscape', // Establece la orientación horizontal
                        pageSize: 'A4', // Tamaño de la hoja
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la columna de "Acciones"
                        },
                        customize: function (doc) {
                            // Ajuste de tamaño de fuente para asegurar que todo quepa
                            doc.defaultStyle.fontSize = 8; // Reducir tamaño de fuente para ajustarlo a la página
                            doc.styles.tableHeader.fontSize = 10; // Tamaño de fuente de los encabezados

                            // Ajuste automático del ancho de las columnas
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                            // Agregar paginación en el PDF si la tabla es demasiado grande para caber en una página
                            doc.pageMargins = [5, 5, 5, 5]; // Márgenes alrededor del contenido
                            doc.content[1].table.body.forEach(function (row) {
                                row.forEach(function (cell) {
                                    // Ajustar el tamaño de cada celda si es necesario
                                    if (typeof cell === 'object' && cell.text) {
                                        cell.text = cell.text.trim();
                                    }
                                });
                            });

                            // Dividir la tabla en páginas si es necesario
                            doc.content[1].table.pageBreak = 'auto';
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Exportar a CSV',
                        className: 'dt-button buttons-csv',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluir la columna "Acciones"
                        }
                    }

               ],
               initComplete: function () {
                   // Ocultar los botones generados automáticamente
                   $('.dt-buttons').hide();
               }
           });

           // Exportar a Excel
           $('#exportExcel').on('click', function() {
               table.button('.buttons-excel').trigger();
           });

           // Exportar a PDF
           $('#exportPDF').on('click', function() {
               table.button('.buttons-pdf').trigger();
           });

           // Exportar a CSV
            $('#exportCSV').on('click', function() {
                table.button('.buttons-csv').trigger();
            });
       });
   </script>

</body>
</html>

