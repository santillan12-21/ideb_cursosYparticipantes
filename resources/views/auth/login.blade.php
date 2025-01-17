<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border: 2px solid #333;
        }
        .login-container img {
            width: 180px;
            margin-bottom: 20px;
        }
        .btn-login {
            width: 100%;
            background-color: #333;
            color: #fff;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.5em;
        }
        .password-container {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autofocus>
            </div>
            <br>
            <div class="form-group password-container">
                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                <span class="toggle-password" onclick="togglePassword()" id="togglePassword">👁️</span>
            </div>
            <br>
            <button type="submit" class="btn btn-login">Iniciar sesión</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            const isPasswordVisible = passwordField.getAttribute('type') === 'password';

            passwordField.setAttribute('type', isPasswordVisible ? 'text' : 'password');
            toggleIcon.textContent = isPasswordVisible ? '👁️' : '🙈';
        }
    </script>
</body>
</html>
