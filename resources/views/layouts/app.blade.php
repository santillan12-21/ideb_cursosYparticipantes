<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Incluir FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
            position: relative;
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
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            justify-items: center;
        }

        .grid a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 100px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .grid a:hover {
            background-color: #444;
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

        .menu-icon {
            display: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .menu-icon {
                display: block;
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #333;
            transition: left 0.3s;
            z-index: 1000;
            padding-top: 60px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #444;
        }

    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo2.jpeg') }}" alt="Logo" class="logo">
        <span class="menu-icon" onclick="toggleSidebar()">☰</span>
        <nav>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-button">Salir</button>
            </form>
            <a href="/Inicio">Inicio</a>
            <a href="{{ route('profile') }}">Mi Perfil</a>
        </nav>
    </header>

    <div class="sidebar" id="sidebar">
        <a href="/users">Creación usuario</a>
        <a href="/cursos">Cursos</a>
        <a href="/participantes">Participantes</a>
        <a href="/">Ruta archivos</a>
        <a href="/export-db">Exportar Base de Datos</a>
        <a href="{{ route('database.import') }}">Importar Base de Datos</a>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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
