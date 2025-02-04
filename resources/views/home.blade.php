<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
            position: relative;
            z-index: 10;
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

        .menu-icon {
            display: block;
            font-size: 30px;
            color: white;
            cursor: pointer;
            z-index: 10;
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }
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

        .sidebar {
            position: fixed;
            top: 60px;
            left: -250px;
            width: 250px;
            height: calc(100% - 60px);
            background-color: #333;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            transition: left 0.3s ease;
            z-index: 5;
            margin-top: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        /* Nuevo estilo para el enlace de importar base de datos */
        .sidebar-import-link {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 20px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .sidebar-import-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
        <span class="menu-icon" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </span>
        <nav>
            <a href="/Inicio">Inicio</a>
            <a href="{{ route('profile') }}">Mi Perfil</a>
            <li>
                <a href="{{ route('configuraciones.index') }}">
                    <img src="{{ asset('images/imagenuerca2.png') }}" alt="Configuraciones" class="logo">
                </a>
            </li>
        </nav>
    </header>

    <div class="sidebar" id="sidebar">
        <a style="color:#333">Trampa</a>
        <a style="color:#333">Trampa</a>
        <a href="/users">Creación usuario</a>
        <a href="/cursos">Cursos</a>
        <a href="/participantes">Participantes</a>
        <a href="/registro">Registro de curso</a>
        <a href="/">Ruta archivos</a>
        <a href="/export-db">Exportar Base de Datos</a>

        <!-- Nuevo enlace para importar base de datos -->
        <a href="#" onclick="selectFile()" class="sidebar-import-link">
            Importar Base de Datos
        </a>

        <!-- Nuevo enlace para cerrar sesión -->
        <a href="#" onclick="document.getElementById('logout-form').submit()">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>Bienvenido</h1>
        <div class="grid">
            <form id="importForm" action="{{ route('database.import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                @csrf
                <input type="file" id="databaseFile" name="database_file" accept=".sql" style="display: none;" required>

            </form>
        </div>
    </div>

    <!-- Formulario de logout oculto -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function selectFile() {
            const fileInput = document.getElementById('databaseFile');
            const form = document.getElementById('importForm');

            fileInput.click();

            fileInput.addEventListener('change', function () {
                if (fileInput.files.length > 0) {
                    form.submit();
                }
            });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.style.left === '0px') {
                sidebar.style.left = '-250px';
            } else {
                sidebar.style.left = '0px';
            }
        }
    </script>
</body>
</html>
