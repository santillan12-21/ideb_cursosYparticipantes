<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Participantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            display: flex;
            justify-content: center; /* Centra la tabla horizontalmente */
            align-items: center; /* Opcional: centrar verticalmente si la altura es mayor */
            flex-direction: column; /* Mantiene el contenido en columna */
        }

        table {
            width: 100%; /* Asegura que la tabla ocupe el 100% del ancho de su contenedor */
            max-width: 1200px; /* Limita el tamaño máximo de la tabla */
            margin: 0 auto; /* Centra la tabla en el contenedor */
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

        .dataTables_wrapper .dt-buttons {
            margin-bottom: 20px; /* Espacio entre botones y tabla */
        }

        .dt-button {
            margin-right: 10px; /* Espacio entre botones */
        }

        /* Estilos personalizados para los botones de exportación */
        .dt-button.buttons-excel {
            background-color: #28a745; /* Verde */
            color: white;
            border: none;
        }

        .dt-button.buttons-pdf {
            background-color: #dc3545; /* Rojo */
            color: white;
            border: none;
        }

        .dt-button:hover {
            opacity: 0.8; /* Efecto hover */
        }
    </style>

    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h2 class="text-center mb-4">Lista de Participantes</h2>

        <table id="participantesTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>N*</th>
                    <th>Nombre del Postulante</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Edad</th>
                    <th>Dirección</th>
                    <th>Escolaridad</th>
                    <th>CURP</th>
                    <th>Empresa</th>
                    <th>Puesto</th>
                    <th>Pago</th>
                    <th>Fecha del Curso</th>
                    <th>Curso Inscrito</th>
                    <th>Estado de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participantes as $participante)
                <tr>
                    <td>{{ $participante->N }}</td>
                    <td>{{ $participante->NombredelPostulante }}</td>
                    <td>{{ $participante->Correo }}</td>
                    <td>{{ $participante->Telefono }}</td>
                    <td>{{ $participante->Edad }}</td>
                    <td>{{ $participante->Direccion }}</td>
                    <td>{{ $participante->Escolaridad }}</td>
                    <td>{{ $participante->Curp }}</td>
                    <td>{{ $participante->Empresa }}</td>
                    <td>{{ $participante->Puesto }}</td>
                    <td>{{ $participante->Pago }}</td>
                    <td>{{ $participante->FechadelCurso }}</td>
                    <td>{{ $participante->CursoInscrito }}</td>
                    <td>{{ $participante->EstadoDePago }}</td>
                    <td>
                        <!-- Botón para editar -->
                        <a href="{{ route('participantes.edit', $participante->N) }}" class="btn btn-warning">Editar</a>

                        <!-- Botón para eliminar -->
                        <button type="button" class="btn btn-danger" onclick="confirmarEliminacion('{{ $participante->N }}')">Eliminar</button>

                        <!-- Formulario oculto para eliminar -->
                        <form id="eliminar-form-{{ $participante->N }}" action="{{ route('participantes.destroy', $participante->N) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón para agregar nuevo participante -->
        <a href="{{ route('participantes.create') }}" class="btn btn-primary">Agregar Nuevo Participante</a>

    </div>

    <!-- Required scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables scripts -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>

    <!-- JSZip and pdfMake for Excel and PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- DataTables HTML5 export buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    <!-- Initialize DataTable with export buttons -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#participantesTable').DataTable({
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
                ]
            });
        });

        // Confirm deletion function
        function confirmarEliminacion(id) {
          Swal.fire({
              title: '¿Estás seguro?',
              text: "¿Quieres eliminar este participante?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('eliminar-form-' + id).submit();
              }
          });
      }
    </script>

</body>
</html>

