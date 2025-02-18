@extends('layouts.app')

@section('content')
    <h3 class="text-center mb-4">Documentos del Curso</h3>
    <form action="{{ route('curso.paso4.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Temario -->
        <div class="mb-3">
            <label class="form-label">Temario</label>
            <input type="text" name="Temario" class="form-control" value="{{ old('Temario') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Drive Temario</label>
            <input type="text" name="DriveTemario" class="form-control" value="{{ old('DriveTemario') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Archivo Local - Temario</label>
            <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Temario')">Crear carpeta local</button>
            <div id="archivoTemarioContainer" style="display: none;" class="mt-2">
                <input type="file" name="TemarioLocal" class="form-control">
                @if(session('cursos_paso4.TemarioLocal'))
                    <div class="mt-2">
                        Archivo subido: {{ session('cursos_paso4.TemarioLocal') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Itinerario -->
        <div class="mb-3">
            <label class="form-label">Itinerario</label>
            <input type="text" name="Itinerario" class="form-control" value="{{ old('Itinerario') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Drive Itinerario</label>
            <input type="text" name="DriveItinerario" class="form-control" value="{{ old('DriveItinerario') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Archivo Local - Itinerario</label>
            <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Itinerario')">Crear carpeta local</button>
            <div id="archivoItinerarioContainer" style="display: none;" class="mt-2">
                <input type="file" name="ItinerarioLocal" class="form-control">
                @if(session('cursos_paso4.ItinerarioLocal'))
                    <div class="mt-2">
                        Archivo subido: {{ session('cursos_paso4.ItinerarioLocal') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Planeación -->
        <div class="mb-3">
            <label class="form-label">Planeación</label>
            <input type="text" name="Planeación" class="form-control" value="{{ old('Planeación') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Drive Planeación</label>
            <input type="text" name="DrivePlaneación" class="form-control" value="{{ old('DrivePlaneación') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Archivo Local - Planeación</label>
            <button type="button" class="btn btn-secondary btn-sm" onclick="crearCarpeta('Planeación')">Crear carpeta local</button>
            <div id="archivoPlaneacionContainer" style="display: none;" class="mt-2">
                <input type="file" name="PlaneaciónLocal" class="form-control">
                @if(session('cursos_paso4.PlaneaciónLocal'))
                    <div class="mt-2">
                        Archivo subido: {{ session('cursos_paso4.PlaneaciónLocal') }}
                    </div>
                @endif
            </div>
        </div>


        <!-- Botones -->
        <div class="mb-3 d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Siguiente</button>
            <a href="{{ route('curso.paso3') }}" class="btn btn-secondary">Atrás</a>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancelar</button>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <img src="{{ asset('images/logo3.png') }}" alt="Logo">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <div class="step-indicator">
                        <div class="step">Paso 1 Datos del Curso</div>
                        <div class="step">Paso 2 Modalidad del Curso</div>
                        <div class="step">Paso 3 Formato de Flyer / Imagen</div>
                        <div class="step active">Paso 4 Documentos del Curso</div>
                        <div class="step">Paso 5 Material de Apoyo</div>
                        <div class="step">Paso 6 Documentos de Evaluación</div>
                        <div class="step">Paso 7 Documentación STPS y Certificados</div>
                    </div>
                    <p>Al dar click a Confirmar se va a borrar toda la información y lo regresará a la ventana de inicio.</p>
                    <div class="buttons-container">
                        <a href="{{ route('cursos.index') }}" class="btn btn-primary">Confirmar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
                <!-- Pie de página del Modal -->
                <div class="modal-footer text-center">
                    Soporte y servicios técnicos y de ingeniería.
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function crearCarpeta(tipo) {
    fetch('/crear-carpeta', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tipo: tipo,
            nombreCarpeta: tipo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Carpeta creada exitosamente: ' + data.ruta);
            // Mostrar el contenedor de archivos correspondiente
            const contenedor = document.getElementById(`archivo${tipo.replace('ó', 'o')}Container`);
            if (contenedor) {
                contenedor.style.display = 'block';
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
