@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Curso - Paso 3</h1>
    <h2>Formato de Flyer / Imagen</h2>

    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('images/logo3.png') }}" alt="Logo">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="step-indicator">
                        <div class="step">Paso 1 Datos del Curso</div>
                        <div class="step">Paso 2 Modalidad del Curso</div>
                        <div class="step active">Paso 3 Formato de Flyer / Imagen</div>
                        <div class="step">Paso 4 Documentos del Curso</div>
                        <div class="step">Paso 5 Material de Apoyo</div>
                        <div class="step">Paso 6 Documentos de Evaluación</div>
                        <div class="step">Paso 7 Documentación STPS y Certificados</div>
                    </div>
                    <p>Al dar click a Confirmar se va a borrar toda la información y lo regresará a la venta de inicio.</p>
                    <div class="buttons-container">
                        <a href="{{ route('cursos.index') }}" class="btn btn-primary">Confirmar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="support-text">
                        Soporte y servicios técnicos y de ingeniería.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('curso.paso3.guardar') }}" enctype="multipart/form-data">
        @csrf

        <!-- Sección Sin Fecha -->
        <div class="mb-4">
            <h3>Sin Fecha</h3>
            <label for="SinFecha">Porcentaje de Sin Fecha:</label>
            <input type="text" name="SinFecha" value="{{ old('SinFecha', session('cursos_paso3.SinFecha') ?? '') }}" required>
            <label for="DriveSinFecha">URL Drive (opcional):</label>
            <input type="text" name="DriveSinFecha" value="{{ old('DriveSinFecha', session('cursos_paso3.DriveSinFecha') ?? '') }}">
            <!-- Botón para crear carpeta local -->
            <button type="button" class="btn btn-success btn-crear-carpeta" data-tipo="SinFecha">
                Crear carpeta local
            </button>
            <!-- Campo para seleccionar archivo -->
            <div class="archivo-local" style="{{ session('cursos_paso3.SinFechaLocal') ? 'display: block;' : 'display: none;' }}">
                <label>Archivo Local (opcional):</label>
                @if(session('cursos_paso3.SinFechaLocal'))
                    <p>Archivo subido: {{ session('cursos_paso3.SinFechaLocal') }}</p>
                @else
                    <input type="file" name="SinFechaLocal">
                @endif
            </div>
        </div>

        <!-- Sección Facebook -->
        <div class="mb-4">
            <h3>Facebook</h3>
            <label for="Facebook">Porcentaje de Facebook:</label>
            <input type="text" name="Facebook" value="{{ old('Facebook', session('cursos_paso3.Facebook') ?? '') }}" required>
            <label for="DriveFacebook">URL Drive (opcional):</label>
            <input type="text" name="DriveFacebook" value="{{ old('DriveFacebook', session('cursos_paso3.DriveFacebook') ?? '') }}">
            <!-- Botón para crear carpeta local -->
            <button type="button" class="btn btn-success btn-crear-carpeta" data-tipo="Facebook">
                Crear carpeta local
            </button>
            <!-- Campo para seleccionar archivo -->
            <div class="archivo-local" style="{{ session('cursos_paso3.FacebookLocal') ? 'display: block;' : 'display: none;' }}">
                <label>Archivo Local (opcional):</label>
                @if(session('cursos_paso3.FacebookLocal'))
                    <p>Archivo subido: {{ session('cursos_paso3.FacebookLocal') }}</p>
                @else
                    <input type="file" name="FacebookLocal">
                @endif
            </div>
        </div>

        <!-- Sección LinkedIn -->
        <div class="mb-4">
            <h3>LinkedIn</h3>
            <label for="Linkedin">Porcentaje de LinkedIn:</label>
            <input type="text" name="Linkedin" value="{{ old('Linkedin', session('cursos_paso3.Linkedin') ?? '') }}" required>
            <label for="DriveLinkedin">URL Drive (opcional):</label>
            <input type="text" name="DriveLinkedin" value="{{ old('DriveLinkedin', session('cursos_paso3.DriveLinkedin') ?? '') }}">
            <!-- Botón para crear carpeta local -->
            <button type="button" class="btn btn-success btn-crear-carpeta" data-tipo="LinkedIn">
                Crear carpeta local
            </button>
            <!-- Campo para seleccionar archivo -->
            <div class="archivo-local" style="{{ session('cursos_paso3.LinkedInLocal') ? 'display: block;' : 'display: none;' }}">
                <label>Archivo Local (opcional):</label>
                @if(session('cursos_paso3.LinkedInLocal'))
                    <p>Archivo subido: {{ session('cursos_paso3.LinkedInLocal') }}</p>
                @else
                    <input type="file" name="LinkedInLocal">
                @endif
            </div>
        </div>

        <!-- Sección Instagram -->
        <div class="mb-4">
            <h3>Instagram</h3>
            <label for="Instagram">Porcentaje de Instagram:</label>
            <input type="text" name="Instagram" value="{{ old('Instagram', session('cursos_paso3.Instagram') ?? '') }}" required>
            <label for="DriveInstagram">URL Drive (opcional):</label>
            <input type="text" name="DriveInstagram" value="{{ old('DriveInstagram', session('cursos_paso3.DriveInstagram') ?? '') }}">
            <!-- Botón para crear carpeta local -->
            <button type="button" class="btn btn-success btn-crear-carpeta" data-tipo="Instagram">
                Crear carpeta local
            </button>
            <!-- Campo para seleccionar archivo -->
            <div class="archivo-local" style="{{ session('cursos_paso3.InstagramLocal') ? 'display: block;' : 'display: none;' }}">
                <label>Archivo Local (opcional):</label>
                @if(session('cursos_paso3.InstagramLocal'))
                    <p>Archivo subido: {{ session('cursos_paso3.InstagramLocal') }}</p>
                @else
                    <input type="file" name="InstagramLocal">
                @endif
            </div>
        </div>

        <!-- Botones de navegación -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('curso.paso2') }}" class="btn btn-secondary">Atrás</a>
            <button type="submit" class="btn btn-primary">Siguiente</button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script para manejar la creación de carpetas y mostrar el campo de archivo
    document.querySelectorAll('.btn-crear-carpeta').forEach(button => {
        button.addEventListener('click', async () => {
            const tipo = button.getAttribute('data-tipo');
            try {
                // Llamada AJAX para crear la carpeta
                const response = await fetch('/crear-carpeta', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ tipo: tipo, nombreCarpeta: tipo })
                });
                const result = await response.json();
                if (result.success) {
                    alert(result.message);
                    // Mostrar el campo de archivo correspondiente
                    button.nextElementSibling.style.display = 'block';
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('Error al crear la carpeta.');
            }
        });
    });
</script>

<!-- Estilos -->
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
    }
    header img {
        width: 100px;
        height: auto;
    }
    .modal-header {
        background-color: #000;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 1rem;
    }
    .modal-header img {
        background-color: transparent;
        max-width: 200px;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    .modal-body {
        text-align: center;
        font-size: 16px;
    }
    .step-indicator {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }
    .step {
        font-size: 14px;
        color: #777;
        font-weight: bold;
    }
    .step.active {
        color: #007bff;
    }
    .support-text {
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }
    .modal-dialog {
        max-width: 80%;
        max-height: 90vh;
    }
    .modal-content {
        height: 90%;
    }
    .modal-body {
        height: calc(100% - 120px);
        overflow-y: auto;
    }
    .modal-footer {
        display: flex;
        justify-content: center;
    }
    .buttons-container {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }
    .form-container {
        padding-top: 30px;
    }
</style>
@endsection
