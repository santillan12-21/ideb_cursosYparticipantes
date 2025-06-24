@extends('home')
@section('title', '- Crear Usuario')
@section('nav')

<style>
   .container {
    margin-top: 10% !important;
   }
   h1
    {
         text-align: center;
         margin-bottom: 20px;
    }
    label {
        font-weight: bold;

    }
</style>
    
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ><h1>{{ __('Crear Usuario') }}</h1></div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nombre') }}</label>
                            <input  style="width: 100%" id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">{{ __('Apellido') }}</label>
                            <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror"
                                   name="apellido" value="{{ old('apellido') }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="edad" class="form-label">{{ __('Edad') }}</label>
                            <input id="edad" type="number" class="form-control @error('edad') is-invalid @enderror"
                                   name="edad" value="{{ old('edad') }}" required min="0">
                            @error('edad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">{{ __('Teléfono') }}</label>
                            <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror"
                                   name="telefono" value="{{ old('telefono') }}" required>
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="puesto" class='form-label'>{{ __('Puesto') }}</label>
                            <select id='puesto' class='form-control @error('puesto') is-invalid @enderror' name='puesto' required>
                                <option value="">Seleccione un puesto</option>
                                <option value='Programador' {{ old('puesto') == 'Programador' ? 'selected' : '' }}>
                                    {{ __('Programador') }}
                                </option>
                                <option value='Administrador' {{ old('puesto') == 'Administrador' ? 'selected' : '' }}>
                                    {{ __('Administrador') }}
                                </option>
                                <option value='Mantenimiento' {{ old('puesto') == 'Mantenimiento' ? 'selected' : '' }}>
                                    {{ __('Mantenimiento') }}
                                </option>
                                <option value='Operacion' {{ old('puesto') == 'Operacion' ? 'selected' : '' }}>
                                    {{ __('Operación') }}
                                </option>
                            </select>
                            @error('puesto')
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class='mb-3'>
                            <label for='password' class='form-label'>{{ __('Contraseña') }}</label>
                            <input id='password' type='password'
                                   class='form-control @error("password") is-invalid @enderror'
                                   name='password' required>
                            @error('password')
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Campo para confirmar contraseña -->
                        <div class='mb-3'>
                            <label for='password_confirmation' class='form-label'>{{ __('Confirmar Contraseña') }}</label>
                            <input id='password_confirmation' type='password'
                                   class='form-control @error("password_confirmation") is-invalid @enderror'
                                   name='password_confirmation' required>
                            @error('password_confirmation')
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class='d-grid gap-2'>
                            <button type='submit' class='btn btn-primary'>
                                {{ __('Registrar Usuario') }}
                            </button>
                            <a href="/users" class='btn btn-danger'>
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
