@extends('layouts.app') 

@section('content')
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<style>
    .back-arrow {
        font-size: 1.5rem;
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }
    .back-arrow:hover {
        color: #007bff;
    }
    .header-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 20px;
    }
    .back-button-container {
        position: absolute;
        left: 0;
    }
    .botones {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
</style>

<div class="container">
    <div class="header-container mt-5">
        <div class="back-button-container">
            <a href="{{ route('participantes.index') }}" class="back-arrow" title="Regresar">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h2 class="text-center">Registrar Nuevo Participante</h2>
    </div>

    <!-- Mostrar mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('participantes.store') }}" method="POST">
        @csrf 
        <div class="mb-3">
            <label for="N" class="form-label">Número de Participante (N)</label>
            <input type="text" class="form-control" id="N" name="N" required>
        </div>
        <div class="mb-3">
            <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
            <input type="text" class="form-control" id="NombredelPostulante" name="NombredelPostulante" required>
        </div>
        <div class="mb-3">
            <label for="Correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="Correo" name="Correo" required>
        </div>
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono (10 dígitos)</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" 
                   maxlength="10" pattern="\d{10}" title="El teléfono debe tener 10 dígitos numéricos" required>
        </div>
        <div class="mb-3">
            <label for="Edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="Edad" name="Edad" min="18" max="90" required>
        </div>
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" required>
        </div>
        <div class="mb-3">
            <label for="Escolaridad" class="form-label">Escolaridad</label>
            <select class="form-select form-control" id="Escolaridad" name="Escolaridad" required>
                <option value="" disabled selected>Seleccione escolaridad</option>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
                <option value="Preparatoria">Preparatoria</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestría">Maestría</option>
                <option value="Doctorado">Doctorado</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="Curp" class="form-label">CURP (18 caracteres)</label>
            <input type="text" class="form-control" id="Curp" name="Curp" 
                   maxlength="18" minlength="18" style="text-transform: uppercase;" required>
        </div>
        <div class="mb-3">
            <label for="RazónSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="RazónSocial" name="RazónSocial" required>
        </div>
        <div class="mb-3">
            <label for="Empresa" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="Empresa" name="Empresa" required>
        </div>
        <div class="mb-3">
            <label for="RFCEmpresa" class="form-label">RFC de la Empresa</label>
            <input type="text" class="form-control" id="RFCEmpresa" name="RFCEmpresa" required>
        </div>
        <div class="mb-3">
            <label for="Puesto" class="form-label">Puesto</label>
            <input type="text" class="form-control" id="Puesto" name="Puesto" required placeholder="Escribe el puesto...">
        </div>
        <div class="mb-3">
            <label for="Ocupacion" class="form-label">Ocupación específica</label>
            <input type="text" class="form-control" id="Ocupacion" name="Ocupacion" required placeholder="Escribe la ocupación...">
        </div>
        <!-- Pago -->
        <div class="mb-3">
            <label for="Pago" class="form-label">Pago</label>
            <input type="text" class="form-control" id="Pago" name="Pago" required>
        </div>
        <!-- Estado de Pago -->
        <div class="mb-3">
            <label for="EstadoDePago" class="form-label">Estado de Pago</label>
            <select class="form-select form-control" id="EstadoDePago" name="EstadoDePago" required>
                <option value="" disabled selected>Opciones de Pago</option>
                <option value="Pagado">Pagado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Anticipo">Anticipo</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="FechadelCurso" class="form-label">Fecha del Curso</label>
            <input type="date" class="form-control" id="FechadelCurso" name="FechadelCurso" required>
        </div>
        <!-- Selección de cursos -->
        <div class="mb-3">
            <label for="cursos" class="form-label">Selecciona los cursos en los que deseas inscribirte:</label>
            <select class="form-select form-control" id="cursos" name="cursos[]" multiple required>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->NombredelCurso }}</option>
                @endforeach
            </select>
            <small class="text-muted">Mantén presionado Ctrl (o Cmd) para seleccionar múltiples cursos.</small>
        </div>

        <div id="detallesCursos" class="mb-3" style="display: none;">
            <h5>Detalles de los Cursos Seleccionados:</h5>
            <div id="listaDetalles" class="list-group">
                <!-- Se llenará dinámicamente -->
            </div>
        </div>

        <!-- Botones de envío -->
        <div class="botones">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('participantes.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const puestos = [
        "01 Cultivo, crianza y aprovechamiento", "01.1 Agricultura y silvicultura", "01.2 Ganadería",
        "01.3 Pesca y acuacultura", "02 Extracción y suministro", "02.1 Exploración",
        "02.2 Extracción", "02.3 Refinación y beneficio", "02.4 Provisión de energia",
        "02.5 Provisión de agua", "03 Construcción", "03.1 Planeación y dirección de obras",
        "03.2 Edificación y urbanización", "03.3 Acabado", "03.4 Instalación y mantenimiento",
        "04 Tecnologia", "04.1 Mecánica", "04.2 Electricidad", "04.3 Electrónica",
        "04.4 Informática", "04.5 Telecomunicaciones", "04.6 Procesos industriales",
        "05 Procesamiento y fabricación", "05.1 Minerales no metálicos", "05.2 Metales",
        "05.3 Alimento y bebidas", "05.4 Textiles y prendas de vestir", "05.5 Materia orgánica",
        "05.6 Productos químicos", "05.7 Productos metálicos y de hule y plástico",
        "05.8 Productos eléctricos y electrónicos", "05.9 Productos impresos",
        "06 Transporte", "06.1 Ferroviario", "06.2 Autotransporte", "06.3 Aéreo",
        "06.4 Maritimo y fluvial", "06.5 Servicios de apoyo", "07 Provisión de bienes y servicios",
        "07.1 Comercio", "07.2 Alimentación y hospedaje", "07.3 Turismo",
        "07.4 Deporte y esparcimiento.", "07.5 Servicios personales",
        "07.6 Reparación de artículos de uso doméstico y personal", "7.7 Limpieza",
        "07.8 Servicio postal y mensajeria", "08 Gestión y soporte administrativo",
        "08.1 Bolsa, banca y seguros", "08.2 Administración", "08.3 Servicios legales",
        "09 Salud y protección social", "09.1 Servicios médicos",
        "09.2 Inspección sanitaria y del medio ambiente", "09.3 Seguridad social",
        "09.4 Protección de bienes y/o personas", "10 Comunicación", "10.1 Publicación",
        "10.2 Radio, cine, televisión y teatro", "10.3 Interpretación artística",
        "10.4 Traducción e interpretación lingüística", "10.5 Publicidad, propaganda y relaciones públicas",
        "11 Desarrollo y extensión del conocimiento", "11.1 Investigación", "11.2 Enseñanza",
        "11.3 Difusión cultural"
    ];

    $("#Puesto").autocomplete({
        source: puestos,
        minLength: 0,
        select: function (event, ui) {
            $("#Puesto").val(ui.item.value);
            return false;
        }
    }).focus(function() {
        $(this).autocomplete("search", "");
    });

    $('#cursos').on('change', function() {
        var selectedIds = $(this).val();
        var listaDetalles = $('#listaDetalles');
        var detallesContainer = $('#detallesCursos');

        if (selectedIds && selectedIds.length > 0) {
            $.ajax({
                url: "{{ route('participantes.cursos-detalles') }}",
                type: "GET",
                data: { ids: selectedIds },
                success: function(data) {
                    listaDetalles.empty();
                    data.forEach(function(curso) {
                        var fechaI = curso.fecha_inicio ? curso.fecha_inicio : 'No definida';
                        var fechaT = curso.fecha_termino ? curso.fecha_termino : 'No definida';
                        
                        listaDetalles.append(
                            '<div class="list-group-item">' +
                                '<strong>' + curso.nombre + '</strong><br>' +
                                '<small>Inicio: ' + fechaI + ' | Término: ' + fechaT + '</small>' +
                            '</div>'
                        );

                        // Si es el primer curso seleccionado, actualizamos el campo general de fecha del curso
                        if (selectedIds.indexOf(curso.id.toString()) === 0) {
                             $('#FechadelCurso').val(curso.fecha_inicio);
                        }
                    });
                    detallesContainer.fadeIn();
                }
            });
        } else {
            detallesContainer.fadeOut();
            listaDetalles.empty();
        }
    });
});
</script>
@endsection
