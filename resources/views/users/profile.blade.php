@extends('home')
@section('title', '- Perfil de Usuario')
@section('nav')

<style>
       
        /* Se define dos secciones en el header */
       
        .container {
            text-align: center;
            padding: 10px;
        }
        h1 {
            margin-bottom: 30px;
            font-size: 2em;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
        }
    </style>
<div class="container" style="margin-top: 100px">
    <h1 style="text-align: center; ">Mi Perfil</h1>
    <div class="card" >
        <div class="card-header" style="text-align: center">Información del Usuario</div>
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
                    @if(!in_array($user->puesto, ['Mantenimiento', 'Operacion']))
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar Perfil</a> <!-- Botón para editar -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
