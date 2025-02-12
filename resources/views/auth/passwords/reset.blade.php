<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        :root {
            --primary-gray: #333333;
            --secondary-gray: #666666;
            --light-gray: #f5f5f5;
            --hover-gray: #444444;
        }
        body {
            background-color: var(--light-gray);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .reset-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 420px;
            margin: 20px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            width: 100%;
            object-fit: contain;
        }
        .form-group label {
            font-weight: 500;
            color: var(--primary-gray);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        .form-control {
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            padding: 10px 12px;
            height: auto;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: var(--secondary-gray);
            box-shadow: 0 0 0 0.2rem rgba(102, 102, 102, 0.15);
        }
        .btn-primary {
            background-color: var(--primary-gray);
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 20px;
            transition: background-color 0.2s ease;
        }
        .btn-primary:hover {
            background-color: var(--hover-gray);
        }
        h2 {
            color: var(--primary-gray);
            font-weight: 600;
            margin-bottom: 30px;
            font-size: 1.75rem;
        }
        .alert-danger {
            border-radius: 6px;
            border: none;
            background-color: #fff2f2;
            color: #d63031;
            font-size: 0.9rem;
            padding: 12px 15px;
        }
        .alert-danger ul {
            margin-bottom: 0;
            padding-left: 20px;
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

        /* Estilos para el overlay de carga */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none; /* Oculto por defecto */
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        @media (max-width: 576px) {
            .reset-container {
                margin: 15px;
                padding: 25px;
            }
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="reset-container">
    <div class="logo-container">
        <img src="https://www.idebmexico.com/imagenes/cropped-I-DEB-Negro.png" alt="Logo" class="logo">
    </div>
    <h2 class="text-center">Restablecer Contraseña</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="resetPasswordForm">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $email) }}" required autofocus>
        </div>
        <div class="form-group password-toggle">
            <label for="password">Nueva Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <button type="button" onclick="togglePassword('password', 'toggleIcon1')">
                <i id="toggleIcon1" class="bi bi-eye-slash"></i>
            </button>
        </div>
        <div class="form-group password-toggle">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block" id="submitButton">Restablecer Contraseña</button>
    </form>
    <p class="text-center mt-3">
        <a href="{{ url('/login') }}">Regresar al inicio de sesión</a>
    </p>
</div>

<!-- Overlay de carga -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Cargando...</span>
    </div>
</div>

<!-- Modal de estado -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contraseña Restablecida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¡Tu contraseña ha sido restablecida con éxito!. Regresando al login.
    </div>
  </div>
</div>

<script>
    // Función para alternar la visibilidad de la contraseña
    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(iconId);
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

    // Manejar el envío del formulario
    document.getElementById('resetPasswordForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Evitar el envío predeterminado

        // Mostrar el spinner de carga
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Obtener los datos del formulario
        const formData = new FormData(this);

        try {
            // Enviar la solicitud POST
            const response = await fetch("{{ route('password.update') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            // Ocultar el spinner de carga
            document.getElementById('loadingOverlay').style.display = 'none';
<
            // Verificar si la respuesta es exitosa
            if (response.ok) {
                // Mostrar el modal de éxito
                $('#statusModal').modal('show');

                // Redirigir al login después de 3 segundos
                setTimeout(() => {
                    window.location.href = "{{ url('/login') }}";
                }, 3000);
            } else {
                // Mostrar errores si la respuesta no es exitosa
                const data = await response.json();
                if (data.errors) {
                    let errorHtml = '<ul>';
                    for (const error of Object.values(data.errors)) {
                        errorHtml += `<li>${error}</li>`;
                    }
                    errorHtml += '</ul>';
                    document.querySelector('.alert-danger').innerHTML = errorHtml;
                    document.querySelector('.alert-danger').style.display = 'block';
                }
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('loadingOverlay').style.display = 'none';
        }
    });
</script>
</body>
</html>
