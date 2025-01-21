@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Perfil</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Apellido -->
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido', $user->apellido) }}" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Nueva Contraseña -->
        <div class="form-group">
            <label for="password">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <!-- Confirmar Nueva Contraseña -->
        <div class="form-group">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <!-- Teléfono -->
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
        </div>

        <!-- Edad -->
        <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad', $user->edad) }}">
        </div>

        <!-- Puesto -->
        <div class="form-group">
            <label for="puesto">Puesto</label>
            <input type="text" name="puesto" id="puesto" class="form-control" value="{{ old('puesto', $user->puesto) }}">
        </div>

        <!-- Botones -->
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
