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
                        <td><a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-sm btn-info">Ver</a></td>
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
                       title: 'Lista de Cursos',
                       className: 'buttons-excel'
                   },
                   {
                       extend: 'pdfHtml5',
                       title: 'Lista de Cursos',
                       className: 'buttons-pdf'
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
       });
   </script>

</body>
</html>

