@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 6: Documentos de Evaluación</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 6]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Presentación</label>
                    <input type="text" name="Presentación" class="form-control"
                           value="{{ $curso->Presentación }}" required>
                           <label for="">Subir archivo</label>
                           <input type="file" name="PresentacionLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutapresentacion)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutapresentacion }}
                             </div>
                            @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Evaluación Diagnóstica</label>
                    <input type="text" name="Evaluación_diagnostica" class="form-control"
                           value="{{ $curso->Evaluación_diagnostica }}" required>
                           <label for="">Subir archivo</label>
                           <input type="file" name="EvaluacionDiagnosticaLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaEvaluacionDiagnostica)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaEvaluacionDiagnostica }}
                             </div>
                            @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Evaluación de Satisfacción</label>
                    <input type="text" name="EvaluaciondeSatisfacción" class="form-control"
                           value="{{ $curso->EvaluaciondeSatisfacción }}" required>
                           <label for="">Subir archivo</label>
                           <input type="file" name="EvaluacionSatisfaccionLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaEvaluacionSatisfaccion)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaEvaluacionSatisfaccion }}
                             </div>
                            @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Evaluación Final</label>
                    <input type="text" name="EvaluacionFinal" class="form-control"
                           value="{{ $curso->EvaluacionFinal }}" required>
                            <label for="">Subir archivo</label>
                           <input type="file" name="EvaluacionFinalLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaEvaluacionFinal)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaEvaluacionFinal }}
                             </div>
                            @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">DC3</label>
                    <select name="DC3" class="form-select" required>
                        <option value="" disabled>Seleccione el estado del DC3</option>
                        <option value="Tiene DC3" {{ $curso->DC3 == 'Tiene DC3' ? 'selected' : '' }}>Tiene DC3</option>
                        <option value="No tiene DC3" {{ $curso->DC3 == 'No tiene DC3' ? 'selected' : '' }}>No tiene DC3</option>
                        <option value="Por confirmar" {{ $curso->DC3 == 'Por confirmar' ? 'selected' : '' }}>Por confirmar</option>
                    </select>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 6</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
