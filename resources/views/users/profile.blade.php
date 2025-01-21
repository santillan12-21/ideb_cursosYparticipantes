@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mi Perfil</h1>

    <div class="card">
        <div class="card-header">Información del Usuario</div>

        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Nombre:</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $user->name }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Apellido:</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $user->apellido }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Email:</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $user->email }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Puesto:</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $user->puesto }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Teléfono:</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $user->telefono }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Edad:</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $user->edad }}</p>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar Perfil</a> <!-- Botón para editar -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
