<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (para los íconos del ojo) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 500px; /* Aumentamos el ancho del contenedor */
            width: 100%;
            padding: 50px; /* Aumentamos el padding para hacerlo más grande */
            background-color: #ffffff;
            border-radius: 16px; /* Bordes más redondeados */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada */
        }
        .login-container img {
            width: 200px; /* Aumentamos el tamaño de la imagen */
            margin-bottom: 30px; /* Más espacio entre la imagen y el formulario */
            display: block; /* Centrar horizontalmente */
            margin-left: auto;
            margin-right: auto;
        }
        .btn-login {
            width: 100%;
            background-color: #0d6efd;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s ease;
            padding: 12px; /* Botón más grande */
            font-size: 1.1em; /* Texto más grande */
        }
        .btn-login:hover {
            background-color: #0b5ed7;
        }
        .password-toggle {
            position: relative;
        }
        .password-toggle button {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.4em; /* Ícono más grande */
            cursor: pointer;
        }
        .password-toggle button:hover {
            color: #0d6efd;
        }
        .form-control {
            font-size: 1.1em; /* Texto más grande en los campos */
            padding: 12px; /* Más espacio dentro de los campos */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Imagen centrada -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto d-block">

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <!-- Campo oculto como señuelo -->
            <input type="text" style="display:none;" name="fake_email" autocomplete="username">
            <input type="password" style="display:none;" name="fake_password" autocomplete="current-password">

            <!-- Campo de correo electrónico -->
            <div class="mb-4">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autofocus autocomplete="off" value="{{ old('email') }}">
            </div>

            <!-- Campo de contraseña -->
            <div class="mb-4 password-toggle">
                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required autocomplete="off">
                <button type="button" onclick="togglePassword()">
                    <i id="toggleIcon" class="bi bi-eye-slash"></i> <!-- Ícono inicial: ojo cerrado -->
                </button>
            </div>

            <!-- Enlace para recuperar contraseña -->
            <div class="forgot-password-link">
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            </div>

            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn btn-login">Iniciar sesión</button>
        </form>
    </div>

    <script>
        // Función para alternar la visibilidad de la contraseña
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            // Verificar si la contraseña está visible o no
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Mostrar contraseña
                toggleIcon.classList.remove('bi-eye-slash'); // Remover ojo cerrado
                toggleIcon.classList.add('bi-eye');         // Agregar ojo abierto
            } else {
                passwordField.type = 'password'; // Ocultar contraseña
                toggleIcon.classList.remove('bi-eye');       // Remover ojo abierto
                toggleIcon.classList.add('bi-eye-slash');    // Agregar ojo cerrado
            }
        }
    </script>

    <!-- Bootstrap 5 JS (opcional, si necesitas funcionalidades adicionales) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
