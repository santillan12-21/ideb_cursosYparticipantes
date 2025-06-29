@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Editar Paso 7: Documentación STPS y Certificados</h3>

            <form action="{{ route('cursos.update.paso', [$curso->id, 7]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label"><b>Fecha de Registro STPS</b></label>
                    <input type="date" name="FechadeRegistro_STPS" class="form-control"
                           value="{{ $curso->FechadeRegistro_STPS }}">
                           {{-- <input type="file" name="EvaluacionFinalLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaEvaluacionFinal)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaEvaluacionFinal }}
                             </div>
                            @endif --}}
                </div>

                <div class="mb-3">
                    <label class="form-label"> <b>Formato DC5</b></label>
                    <input type="text" name="Formato_DC5" class="form-control" required
                           value="{{ $curso->Formato_DC5 }}">
                    <label for="">Subir archivo</label>
                       <input type="file" name="FormatoDC5Local" class="form-control">
                        @if ($rutaLocal && $rutaLocal->rutaDC5)
                         <div class="mt-2 alert alert-success">
                             Ruta actual Digital: {{ $rutaLocal->rutaDC5 }}
                         </div>
                        @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Formato DC5 - ¿Tiene firma?</label>
                    <select name="Formato_DC5_Tienefirma" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Si" {{ $curso->Formato_DC5_Tienefirma == 'Si' ? 'selected' : '' }}>Sí</option>
                        <option value="No" {{ $curso->Formato_DC5_Tienefirma == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Certificado de Comprobación</b></label>
                    <br>

                    <select name="Certificadodecomprobacion" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Ya obtenida" {{ $curso->Certificadodecomprobacion == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                        <option value="En proceso" {{ $curso->Certificadodecomprobacion == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="No obtenida" {{ $curso->Certificadodecomprobacion == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                    </select>
                    <br>
                    <br>
                      <label for="">Subir archivo</label>
                           <input type="file" name="CertificadoComprobacionLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaCertificadoComprobacion)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaCertificadoComprobacion }}
                             </div>
                        @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Drive de Certificado de Comprobación</label>
                    <input type="text" name="DrivedeCertificadodecomprobacion" class="form-control" required
                           value="{{ $curso->DrivedeCertificadodecomprobacion }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Carta Poder - ¿Tiene firma?</label>
                    <select name="Cartapoder_tienefirma" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Si" {{ $curso->Cartapoder_tienefirma == 'Si' ? 'selected' : '' }}>Sí</option>
                        <option value="No" {{ $curso->Cartapoder_tienefirma == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="DriveCartapoder"> <b>Carta poder</b></label><br>
                    <label class="form-label">Drive Carta Poder</label>
                    <input type="text" name="DriveCartapoder" class="form-control" required
                           value="{{ $curso->DriveCartapoder }}">

                           <label for="">Subir archivo</label>
                           <input type="file" name="CartaPoderLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutacartapoder)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutacartapoder }}
                             </div>
                        @endif
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>UDEMY</b></label><br>
                    <select name="UDEMY" class="form-select" required>
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="Prellenado" {{ $curso->UDEMY == 'Prellenado' ? 'selected' : '' }}>Prellenado</option>
                        <option value="No se ha prellenado" {{ $curso->UDEMY == 'No se ha prellenado' ? 'selected' : '' }}>No se ha prellenado</option>
                    </select>
                    <br>
                    <br>
                        <label for="">Subir archivo</label>
                           <input type="file" name="UdemyLocal" class="form-control">
                            @if ($rutaLocal && $rutaLocal->rutaUdemy)
                             <div class="mt-2 alert alert-success">
                                 Ruta actual Digital: {{ $rutaLocal->rutaUdemy }}
                             </div>
                        @endif
                    
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Paso 7</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
