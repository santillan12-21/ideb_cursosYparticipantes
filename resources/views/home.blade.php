<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 10;
        }
        .header-left {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 16px;
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
        .main-nav {
            display: none;
        }

        .menu-icon {
            display: block;
        }

        .header-right {
            gap: 8px;
        }

        .user-name-display {
            max-width: 100px;
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
        /* Estilos para el menú de usuario */
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-menu-trigger {
            background: none;
            border: none;
            color: white;
            padding: 8px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .user-menu-trigger:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .user-menu-trigger i {
            transition: transform 0.3s ease;
        }

        .user-menu-trigger.active i {
            transform: rotate(180deg);
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-info {
            padding: 16px;
            border-bottom: 1px solid #eee;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 0.875rem;
            color: #666;
        }

        .dropdown-items {
            padding: 8px 0;
        }

        .dropdown-item {
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .btn-cerrar-sesion {
            width: calc(100% - 32px);
            margin: 8px 16px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #ff4757, #ff6b81);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-cerrar-sesion:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 71, 87, 0.2);
        }
    </style>
</head>
<body>
    @php
    use Illuminate\Support\Facades\Auth;
    @endphp
   <header>
    <div class="header-left">
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
        <nav class="main-nav">
            <a href="/Inicio">Inicio</a>
            <a href="{{ route('profile') }}">Mi Perfil</a>
            <a href="{{ route('configuraciones.index') }}" class="config-link">
                <img src="{{ asset('images/imagenuerca2.png') }}" alt="Configuraciones" class="config-icon">
            </a>
        </nav>
    </div>

    <div class="header-right">
        @auth
        <div class="user-menu">
            <button class="user-menu-trigger" id="userMenuTrigger">
                <i class="fas fa-user-circle"></i>
                <span class="user-name-display">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->puesto) }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-cerrar-sesion">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
        @endauth

        <button class="menu-icon" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

    <div class="sidebar" id="sidebar">
        <a style="color:#333">Trampa</a>
        <a style="color:#333">Trampa</a>
        <a href="/users">Creación usuario</a>
        <a href="/cursos">Cursos</a>
        <a href="/participantes">Participantes</a>
        <a href="/registro">Registro de curso</a>
        <a href="{{ route('ruta.archivos') }}">Ruta archivos</a>
        <a href="https://drive.google.com/drive/folders/1HRJ_UliysPgzUOm1_XvcLR4MSuAjdODD?usp=sharing" target="_blank" class="drive-link">
            <i class="fab fa-google-drive"></i> Carpeta de Drive
        </a>
        <a href="/export-db">Exportar Base de Datos</a>

        <!-- Nuevo enlace para importar base de datos -->
        <a href="#" onclick="selectFile()" class="sidebar-import-link">
            Importar Base de Datos
        </a>

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
        // Agregar el siguiente código para el menú de usuario
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuTrigger = document.getElementById('userMenuTrigger');
            const userDropdown = document.getElementById('userDropdown');

            function toggleUserMenu(event) {
                event.stopPropagation();
                userMenuTrigger.classList.toggle('active');
                userDropdown.classList.toggle('active');
            }

            function closeUserMenu() {
                userMenuTrigger.classList.remove('active');
                userDropdown.classList.remove('active');
            }

            userMenuTrigger.addEventListener('click', toggleUserMenu);

            // Cerrar el menú cuando se hace clic fuera
            document.addEventListener('click', function(event) {
                const isClickInside = userMenuTrigger.contains(event.target) || userDropdown.contains(event.target);
                if (!isClickInside) {
                    closeUserMenu();
                }
            });

            // Evitar que el menú se cierre cuando se hace clic dentro
            userDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    </script>
</body>
</html>
