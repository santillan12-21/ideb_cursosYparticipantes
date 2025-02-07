@extends('layouts.app') <!-- Asegúrate de tener un layout base -->

@section('content')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<div class="container">
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

    <h2>Registrar Nuevo Participante</h2>
    <form action="{{ route('registro.store') }}" method="POST">
        @csrf <!-- Token CSRF para protección contra ataques -->

        <!-- Nombre del Postulante -->
        <div class="mb-3">
            <label for="NombredelPostulante" class="form-label">Nombre del Postulante</label>
            <input type="text" class="form-control" id="NombredelPostulante" name="NombredelPostulante" required>
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-3">
            <label for="Correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="Correo" name="Correo" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-3">
            <label for="Telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" required>
        </div>

        <!-- Edad -->
        <div class="mb-3">
            <label for="Edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="Edad" name="Edad" required>
        </div>

        <!-- Dirección -->
        <div class="mb-3">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion" required>
        </div>

        <!-- Escolaridad -->
        <div class="mb-3">
            <label for="Escolaridad" class="form-label">Escolaridad</label>
            <input type="text" class="form-control" id="Escolaridad" name="Escolaridad" required>
        </div>

        <!-- CURP -->
        <div class="mb-3">
            <label for="Curp" class="form-label">CURP</label>
            <input type="text" class="form-control" id="Curp" name="Curp" required>
        </div>

        <!-- Razón Social -->
        <div class="mb-3">
            <label for="RazónSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="RazónSocial" name="RazónSocial" required>
        </div>

        <!-- Empresa -->
        <div class="mb-3">
            <label for="Empresa" class="form-label">Empresa</label>
            <input type="text" class="form-control" id="Empresa" name="Empresa" required>
        </div>

        <!-- RFC de la Empresa -->
        <div class="mb-3">
            <label for="RFCEmpresa" class="form-label">RFC de la Empresa</label>
            <input type="text" class="form-control" id="RFCEmpresa" name="RFCEmpresa" required>
        </div>

        <!-- Puesto -->
        <div class="mb-3">
            <label for="Puesto" class="form-label">Área en el que trabaja</label>
            <input type="text" class="form-control" id="Puesto" name="Puesto" placeholder="Escribe el puesto..." required>
        </div>

        <!-- Estado de Pago -->
        <div class="mb-3">
            <label for="EstadoDePago" class="form-label">Como desea pagar</label>
            <select class="form-select" id="EstadoDePago" name="EstadoDePago" required onchange="togglePagoField()">
                <option value="" disabled selected>Opciones de Pago</option>
                <option value="Pagado">Pagar haora</option>
                <option value="Pendiente">Pagar</option>
                <option value="Anticipo">Anticipo</option>
            </select>
        </div>

        <!-- Pago (mostrado u oculto según el estado de pago) -->
        <div id="pagoFieldContainer" style="display: none;">
            <div class="mb-3">
                <label for="Pago" class="form-label">Pago</label>
                <input type="text" class="form-control" id="Pago" name="Pago" placeholder="Ingrese el monto del pago">
            </div>
        </div>

        <div class="mb-3">
            <label for="cursos" class="form-label">Selecciona los cursos en los que deseas inscribirte:</label>
            <select class="form-select" id="cursos" name="cursos[]" multiple required onchange="updateCourseDetails()">
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}"
                            data-fecha="{{ $curso->FechadeInicio }}">
                        {{ $curso->NombredelCurso }} (Inicio: {{ $curso->FechadeInicio }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Información de la Fecha de Inicio (solo lectura) -->
        <div class="mb-3">
            <label for="FechadeInicioDisplay" class="form-label">Fecha de Inicio del Curso</label>
            <input type="text" class="form-control" id="FechadeInicioDisplay" readonly>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script>

    function updateCourseDetails() {
        const cursos = document.getElementById('cursos');
        const fechaDisplay = document.getElementById('FechadeInicioDisplay');

        const selectedOption = cursos.selectedOptions[0];
        const fecha = selectedOption.getAttribute('data-fecha');

        fechaDisplay.value = fecha;
    }

    // Autocompletado para el campo "Puesto"
    $(function () {
        const puestos = [
            "Agricultura y silvicultura", "Ganadería", "Pesca y acuacultura",
            "Exploración", "Extracción", "Refinación y beneficio", "Provisión de energía", "Provisión de agua",
            "Planeación y dirección de obras", "Edificación y urbanización", "Acabado", "Conservación y mantenimiento",
            "Mecánica", "Electricidad", "Electrónica", "Informática", "Telecomunicaciones", "Procesos industriales",
            "Minerales no metálicos", "HCM",
            "Ferroviario", "Autotransporte", "Aéreo", "Marítimo y fluvial", "Servicios de apoyo",
            "Comercio", "Alimentación y hospedaje", "Turismo", "Deporte y esparcimiento", "Servicios personales",
            "Reparación de artículos de uso doméstico y personal", "Limpieza", "Servicio postal y mensajería",
            "Bolsa, banca y seguros", "Administración", "Servicios legales",
            "Servicios médicos", "Inspección sanitaria y del medio ambiente", "Seguridad social",
            "Protección de bienes y/o personas",
            "Minerales no metálicos", "Metales", "Alimentos y bebidas", "Textiles y prendas de vestir",
            "Materia orgánica", "Productos químicos", "Productos metálicos y de hule y plástico",
            "Productos eléctricos y electrónicos", "Productos impresos",
            "Publicación", "Radio, cine, televisión y teatro", "Interpretación artística",
            "Traducción e interpretación lingüística", "Publicidad, propaganda y relaciones públicas",
            "Investigación", "Enseñanza", "Difusión cultural",
        ];
        $("#Puesto").autocomplete({
            source: puestos,
            minLength: 1, // Mínimo de caracteres antes de mostrar sugerencias
            select: function (event, ui) {
                // Al seleccionar una opción, establecer el valor en el campo
                $("#Puesto").val(ui.item.value);
                return false;
            }
        });
    });

    // Función para mostrar/ocultar el campo "Pago"
    function togglePagoField() {
        const estadoPago = document.getElementById('EstadoDePago').value;
        const pagoFieldContainer = document.getElementById('pagoFieldContainer');
        if (estadoPago === 'Pagado' || estadoPago === 'Anticipo') {
            pagoFieldContainer.style.display = 'block'; // Mostrar el campo
            document.getElementById('Pago').setAttribute('required', true); // Hacerlo obligatorio
        } else {
            pagoFieldContainer.style.display = 'none'; // Ocultar el campo
            document.getElementById('Pago').removeAttribute('required'); // Hacerlo opcional
        }
    }
</script>
@endsection
