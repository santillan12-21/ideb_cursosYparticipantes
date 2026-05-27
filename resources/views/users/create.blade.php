@extends('home')
@section('title', '- Crear Usuario')

@section('content')
<style>
    .create-container {
        margin-top: 50px;
        padding-bottom: 50px;
    }
    .create-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        background: white;
    }
    .create-header {
        background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        padding: 40px 30px;
        color: white;
        border-bottom: 4px solid #28a745;
        text-align: center;
        position: relative;
    }
    .create-header h2 {
        font-weight: 300;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    .user-icon-header {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }
    .form-section-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }
</style>

<div class="container create-container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="card create-card">
                <div class="create-header">
                    <a href="{{ route('users.index') }}" class="back-arrow" title="Regresar">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="user-icon-header">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h2 class="mb-0">Añadir Usuario</h2>
                    <p class="mb-0 mt-2 opacity-75">Complete la información para registrar una nueva cuenta</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <h5 class="form-section-title text-primary"><i class="fas fa-id-card me-2"></i> Datos de Identificación</h5>
                                <div class="form-section-card shadow-sm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label small fw-bold text-muted">Nombre(s)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" name="name" id="name" class="form-control form-control-with-icon" value="{{ old('name') }}" placeholder="Ej. Juan" required autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="apellido" class="form-label small fw-bold text-muted">Apellido(s)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                <input type="text" name="apellido" id="apellido" class="form-control form-control-with-icon" value="{{ old('apellido') }}" placeholder="Ej. Pérez" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <h5 class="form-section-title text-primary"><i class="fas fa-briefcase me-2"></i> Información Laboral</h5>
                                <div class="form-section-card shadow-sm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="puesto" class="form-label small fw-bold text-muted">Puesto Asignado</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                                <select name="puesto" id="puesto" class="form-select form-control-with-icon" required>
                                                    <option value="">Seleccione el cargo...</option>
                                                    <option value="Programador" {{ old('puesto') == 'Programador' ? 'selected' : '' }}>Programador</option>
                                                    <option value="Administrador" {{ old('puesto') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                                    <option value="Mantenimiento" {{ old('puesto') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                                    <option value="Operacion" {{ old('puesto') == 'Operacion' ? 'selected' : '' }}>Operación</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label small fw-bold text-muted">Correo Institucional</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" id="email" class="form-control form-control-with-icon" value="{{ old('email') }}" placeholder="usuario@idebmexico.com" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <h5 class="form-section-title text-primary"><i class="fas fa-info-circle me-2"></i> Detalles Adicionales</h5>
                                <div class="form-section-card shadow-sm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telefono" class="form-label small fw-bold text-muted">Teléfono de Contacto</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" name="telefono" id="telefono" class="form-control form-control-with-icon" value="{{ old('telefono') }}" placeholder="10 dígitos" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="edad" class="form-label small fw-bold text-muted">Edad del Usuario</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                <input type="number" name="edad" id="edad" class="form-control form-control-with-icon" value="{{ old('edad') }}" min="18" max="90" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <h5 class="form-section-title text-primary"><i class="fas fa-shield-alt me-2"></i> Credenciales de Acceso</h5>
                                <div class="form-section-card shadow-sm" style="background-color: #fff9f0; border-color: #ffe8cc;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label small fw-bold text-muted">Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" name="password" id="password" class="form-control form-control-with-icon" placeholder="Mínimo 8 caracteres" required>
                                                <button type="button" class="btn btn-outline-secondary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none;" onclick="togglePassword('password')">
                                                    <i class="fas fa-eye" id="eye-password"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label small fw-bold text-muted">Confirmar Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-with-icon" placeholder="Repita la contraseña" required>
                                                <button type="button" class="btn btn-outline-secondary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none;" onclick="togglePassword('password_confirmation')">
                                                    <i class="fas fa-eye" id="eye-password_confirmation"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="botones-container">
                            <button type="submit" class="btn btn-success btn-custom shadow-sm">
                                <i class="fas fa-save me-2"></i> Crear Usuario
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-danger btn-custom shadow-sm">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById('eye-' + fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection
