@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 5: Material de Apoyo</h3>
            <form action="{{ route('cursos.update.paso', [$curso->id, 5]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Digital</label>
                    <input type="text" name="Digital" class="form-control"
                           value="{{ $curso->Digital }}" required>
                           <label for="">Subir archivo</label>
                           <input type="file" name="DigitalLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaMaterialdeapoyo)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaMaterialdeapoyo }}
                             </div>
                            @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive Digital</label>
                    <input type="text" name="DriveDigital" class="form-control"
                           value="{{ $curso->DriveDigital }}" required>
                </div>

                 @php
                    use App\Models\inscripcion;
                    $cursoId = $curso->id;
                    $participante = inscripcion::where('curso_id', $cursoId)->count();
                @endphp
                <div class="mb-3">
                    <label for="">Porcentaje del material impreso y presentable</label>
                    <select name="Impreso_Presentable" class="form-control" id="">
                        <option value=" {{ old('Impreso_presentable') }} " disabled selected>{{ $curso -> Impreso_Presentable }} </option>
                        @for ($i = 1; $i <= $participante; $i++)
                            <option value="{{ $i }}/{{ $participante }}">{{ $i }}/{{ $participante }}</option>
                        @endfor
                    </select>
           {{-- <label class="form-label">Porcentaje del material impreso y presentable</label>
                        <input type="text" name="Impreso_Presentable" class="form-control" value="{{ old('Impreso_Presentable', $curso->Impreso_Presentable ?? ($datosPadre->Impreso_Presentable ?? '')) }}"> --}}
                </div> 

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 5</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
