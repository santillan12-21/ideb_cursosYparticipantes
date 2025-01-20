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
            width: 100px;  /* Aumenta el tamaño del logo */
            height: auto;
            margin-right: 20px;  /* Espacio entre el logo y el menú */
        }


        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: #fff;
            margin-right: 20px;  /* Espacio entre enlaces */
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
            <a href="/users/create">Creacion usuario</a>
            <a href="/cursos">Cursos</a>
            <a href="/participantes">Participante</a>
            <a href="/nuevo-servicio">Nuevo Servicio</a>
            <a href="/ruta-archivos">Ruta Archivos</a>
            <a href="/pagos-pendientes">Pagos Pendientes</a>
            <a href="/pedidos-activos">Pedidos Activos</a>
            <a href="/pedidos-finalizados">Pedidos Finalizados</a>
            <a href="/pedidos-rechazados">Pedidos Rechazados</a>
        </div>
    </div>
</body>
</html>
