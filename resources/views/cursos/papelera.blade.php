@extends('home')
@section('title', '- Papelera de Cursos')

@section('content')
<div class="container-fluid py-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-trash-alt me-2"></i>Papelera de Cursos</h3>
            <a href="{{ route('cursos.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nomenclatura</th>
                            <th>Nombre del Curso</th>
                            <th>Instructor</th>
                            <th>Costo</th>
                            <th>Fecha Desactivación</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cursos as $curso)
                            <tr class="table-danger">
                                <td class="fw-bold">{{ $curso->Nomenclatura }}</td>
                                <td>{{ $curso->NombredelCurso }}</td>
                                <td>{{ $curso->InstructorResponsable }}</td>
                                <td class="text-success fw-bold">${{ number_format((float)$curso->CostodelCurso, 2) }}</td>
                                <td>{{ $curso->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <!-- Botón Reactivar -->
                                        <form action="{{ route('cursos.activar', $curso->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Reactivar">
                                                <i class="fas fa-undo"></i> Reactivar
                                            </button>
                                        </form>

                                        <!-- Botón Borrado Definitivo con Modal -->
                                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalDeleteCurso{{ $curso->id }}">
                                            <i class="fas fa-trash-alt"></i> Eliminar Definitivo
                                        </button>
                                    </div>

                                    <!-- Modal Confirmación Password -->
                                    <div class="modal fade" id="modalDeleteCurso{{ $curso->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="{{ route('cursos.eliminar-definitivo', $curso->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content text-start">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">¿Eliminar Permanentemente?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>El curso <strong>{{ $curso->NombredelCurso }}</strong> será eliminado de forma permanente. Sus subcursos asociados también se verán afectados.</p>
                                                        <p class="text-danger">Esta acción no se puede deshacer.</p>
                                                        <div class="mb-3">
                                                            <label class="form-label text-dark">Ingrese Contraseña de Administrador:</label>
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
                                <td colspan="6" class="text-center py-4 text-muted">No hay cursos en la papelera.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
