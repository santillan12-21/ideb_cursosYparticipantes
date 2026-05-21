@extends('home')
@section('title', '- Papelera de Participantes')
@section('content')
<div class="container">
    <h2 class="text-center mt-5">Papelera de Participantes</h2>
    <p class="text-center text-muted">Aquí se muestran los participantes desactivados. Puedes reactivarlos o eliminarlos definitivamente.</p>

    <div class="mb-4">
        <a href="{{ route('participantes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a la Lista
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>N</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>CURP</th>
                    <th>Empresa</th>
                    <th>Fecha Desactivación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participantes as $participante)
                <tr class="table-danger">
                    <td>{{ $participante->N }}</td>
                    <td>{{ $participante->NombredelPostulante }}</td>
                    <td>{{ $participante->Correo }}</td>
                    <td>{{ $participante->Telefono }}</td>
                    <td>{{ $participante->Curp }}</td>
                    <td>{{ $participante->Empresa }}</td>
                    <td>{{ $participante->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('participantes.activar', $participante->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="Reactivar">
                                <i class="fas fa-undo"></i> Reactivar
                            </button>
                        </form>

                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $participante->id }}">
                            <i class="fas fa-trash"></i> Borrar Definitivo
                        </button>

                        <!-- Modal Confirmación Password -->
                        <div class="modal fade" id="modalEliminar{{ $participante->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('participantes.eliminar-definitivo', $participante->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Confirmar Eliminación Permanente</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-dark">
                                            <p>¿Estás seguro de eliminar a <strong>{{ $participante->nombre }}</strong>? Esta acción no se puede deshacer.</p>
                                            <div class="mb-3">
                                                <label class="form-label">Contraseña de Administrador:</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Eliminar para siempre</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">La papelera está vacía.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $participantes->links() }}
    </div>
</div>
@endsection
