@extends('home')
@section('title', '- Papelera de Usuarios')
@section('content')

<style>
    .users-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .users-table th, .users-table td {
        border: 1px solid #ddd !important;
        padding: 10px !important;
        text-align: left !important;
    }
    .users-table th {
        background-color: #333;
        color: #fff;
    }
    tr.inactive-row {
        background-color: #fff5f5;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid py-4">
    <h1>Papelera de Usuarios</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a la Lista
        </a>
    </div>

    <div class="table-responsive">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Puesto</th>
                    <th>Fecha Desactivación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="inactive-row">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }} {{ $user->apellido }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->puesto }}</td>
                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('users.activar', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Reactivar">
                                    <i class="fas fa-undo"></i> Reactivar
                                </button>
                            </form>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿ELIMINAR DEFINITIVAMENTE? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-dark">
                                    <i class="fas fa-trash-alt"></i> Borrar Definitivo
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">La papelera está vacía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
