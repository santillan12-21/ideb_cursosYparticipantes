@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ __('Perfil de Usuario') }}</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Nombre') }}</label>
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Correo Electrónico') }}</label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Puesto') }}</label>
                        <p class="form-control-static">{{ $user->puesto }}</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('users.edit') }}" class="btn btn-primary">
                            {{ __('Editar Perfil') }}
                        </a>
                        <a href="/Inicio" class="btn btn-secondary">
                            {{ __('Volver al Inicio') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
