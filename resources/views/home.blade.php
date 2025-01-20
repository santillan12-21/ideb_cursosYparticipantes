<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #000000;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        nav {
            display: flex;
            align-items: center;
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
            cursor: pointer;
        }

        .container {
            text-align: center;
            padding: 40px;
        }

        h1 {
            margin-bottom: 30px;
            font-size: 2em;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
        }

        .grid a,
        .grid button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 180px;
            height: 50px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .grid a:hover,
        .grid button:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
        <nav>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-button">Salir</button>
            </form>
            <a href="/Inicio">Inicio</a>
            <a href="{{ route('users.show') }}">Usuario</a>
        </nav>
    </header>

    <div class="container">
        <h1>Acciones</h1>
        <div class="grid">
            <a href="/users/create">Creación usuario</a>
            <a href="/cursos">Cursos</a>
            <a href="/participantes">Participantes</a>
            <a href="/">Ruta archivos</a>
            <a href="/export-db">Exportar Base de Datos</a>
            <form id="importForm" action="{{ route('database.import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                @csrf
                <input type="file" id="databaseFile" name="database_file" accept=".sql" style="display: none;" required>
                <button type="button"
                    onclick="selectFile()">
                    Importar Base de Datos
                </button>
            </form>
        </div>
        <script>
            function selectFile() {
                const fileInput = document.getElementById('databaseFile');
                const form = document.getElementById('importForm');

                // Abrir el selector de archivos
                fileInput.click();

                // Escuchar cambios en el selector de archivos
                fileInput.addEventListener('change', function () {
                    if (fileInput.files.length > 0) {
                        // Si se seleccionó un archivo, enviar el formulario
                        form.submit();
                    }
                });
            }
        </script>
    </div>
</body>
</html>
