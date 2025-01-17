<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Paso 7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Documentación STPS y Certificados</h3>

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('curso.guardar-paso7') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Fecha de Registro STPS</label>
                        <input type="date" name="FechadeRegistro_STPS" class="form-control" value="{{ old('FechadeRegistro_STPS') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Formato DC5</label>
                        <input type="text" name="Formato_DC5" class="form-control" required value="{{ old('Formato_DC5') }}">
                        @error('Formato_DC5')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Formato DC5 - ¿Tiene firma?</label>
                        <select name="Formato_DC5_Tienefirma" class="form-select" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Si" {{ old('Formato_DC5_Tienefirma') == 'Si' ? 'selected' : '' }}>Sí</option>
                            <option value="No" {{ old('Formato_DC5_Tienefirma') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('Formato_DC5_Tienefirma')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Certificado de Comprobación</label>
                        <select name="Certificadodecomprobacion" class="form-select" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Ya obtenida" {{ old('Certificadodecomprobacion') == 'Ya obtenida' ? 'selected' : '' }}>Ya obtenida</option>
                            <option value="En proceso" {{ old('Certificadodecomprobacion') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="No obtenida" {{ old('Certificadodecomprobacion') == 'No obtenida' ? 'selected' : '' }}>No obtenida</option>
                        </select>
                        @error('Certificadodecomprobacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Drive de Certificado de Comprobación</label>
                        <input type="text" name="DrivedeCertificadodecomprobacion" class="form-control" required value="{{ old('DrivedeCertificadodecomprobacion') }}">
                        @error('DrivedeCertificadodecomprobacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carta Poder - ¿Tiene firma?</label>
                        <select name="Cartapoder_tienefirma" class="form-select" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Si" {{ old('Cartapoder_tienefirma') == 'Si' ? 'selected' : '' }}>Sí</option>
                            <option value="No" {{ old('Cartapoder_tienefirma') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('Cartapoder_tienefirma')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Drive Carta Poder</label>
                        <input type="text" name="DriveCartapoder" class="form-control" required value="{{ old('DriveCartapoder') }}">
                        @error('DriveCartapoder')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">UDEMY</label>
                        <select name="UDEMY" class="form-select" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Prellenado" {{ old('UDEMY') == 'Prellenado' ? 'selected' : '' }}>Prellenado</option>
                            <option value="No se ha prellenado" {{ old('UDEMY') == 'No se ha prellenado' ? 'selected' : '' }}>No se ha prellenado</option>
                        </select>
                        @error('UDEMY')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Finalizar</button>
                        <a href="{{ route('curso.paso6') }}" class="btn btn-secondary">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
