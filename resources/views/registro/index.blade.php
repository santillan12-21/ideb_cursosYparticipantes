@extends('home')
@section('title', '- Registrar Participante')
@section('nav')


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logoibeb.ico') }}">


<style>
    input {
        width: 100% !important;
        max-width: 100% !important;
    }

    .container {
        margin: 20px auto !important;
        max-width: 900px !important;
        margin-top: 100px !important; 
    }
</style>


<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h2 style="text-align: center;">Registrar Nuevo Participante</h2>
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
            <input type="text" class="form-control" id="Curp" name="Curp" required oninput="validarCURP(this)">
            <small id="curpError" class="text-danger" style="display: none;">La CURP debe tener 18 caracteres.</small>
        </div>

        <!-- Razón Social -->
        <div class="mb-3">
            <label for="RazónSocial" class="form-label">Razón Social de la empresa en la que labora</label>
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

        <!-- Ocupacion -->
        <div class="mb-3">
            <label for="Puesto" class="form-label">Ocupación especifica</label>
            <input type="text" class="form-control" id="Ocupacion" name="Ocupacion" placeholder="Escribe el puesto..." required>
        </div>

           <!-- Puesto -->
        <div class="mb-3">
            <label for="Puesto" class="form-label">Puesto que ocupa dentro de la empresa</label>
            <input type="text" class="form-control" id="Puesto" name="Puesto" placeholder="Escribe el puesto..." required>
        </div

        <!-- Estado de Pago -->
        <div class="mb-3">
            <label for="EstadoDePago" class="form-label">Como desea pagar</label>
            <select class="form-select" id="EstadoDePago" name="EstadoDePago" required onchange="togglePagoField()">
                <option value="" disabled selected>Opciones de Pago</option>
                <option value="Pagado">Pagado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Anticipo">Anticipo</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>

        <!-- Pago (mostrado u oculto según el estado de pago) -->
        <div id="pagoFieldContainer" style="display: none;">
            <div class="mb-3">
                <label for="Pago" class="form-label">Pago</label>
                <input type="text" class="form-control" id="Pago" name="Pago" placeholder="Ingrese el monto del pago">
            </div>
        </div>

        <!-- Selección de cursos -->
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


    // Previous autocomplete and other scripts remain the same
    $(function () {
        const puestos = [
            // ... (lista de puestos anterior)
        ];

        $("#Puesto").autocomplete({
            source: puestos,
            minLength: 1,
            select: function (event, ui) {
                $("#Puesto").val(ui.item.value);
                return false;
            }
        });
    });

    // Autocompletado para el campo "Puesto"
 // ...otros scripts...

$(function () {
    const puestos = [
        "01 Cultivo, crianza y aprovechamiento", "01.1 Agricultura y silvicultura", "01.2 Ganadería",
        "01.3 Pesca y acuacultura",
        "02 Extracción y suministro",
        "02.1 Exploración",
        "02.2 Extracción",
        "02.3 Refinación y beneficio",
        "02.4 Provisión de energia",
        "02.5 Provisión de agua",
        "03 Construcción",
        "03.1 Planeación y dirección de obras",
        "03.2 Edificación y urbanización",
        "03.3 Acabado",
        "03.4 Instalación y mantenimiento",
        "04 Tecnologia",
        "04.1 Mecánica",
        "04.2 Electricidad",
        "04.3 Electrónica",
        "04.4 Informática",
        "04.5 Telecomunicaciones",
        "04.6 Procesos industriales",
        "05 Procesamiento y fabricación",
        "05.1 Minerales no metálicos",
        "05.2 Metales",
        "05.3 Alimento y bebidas",
        "05.4 Textiles y prendas de vestir",
        "05.5 Materia orgánica",
        "05.6 Productos químicos",
        "05.7 Productos metálicos y de hule y plástico",
        "05.8 Productos eléctricos y electrónicos",
        "05.9 Productos impresos",
        "06 Transporte",
        "06.1 Ferroviario",
        "06.2 Autotransporte",
        "06.3 Aéreo",
        "06.4 Maritimo y fluvial",
        "06.5 Servicios de apoyo",
        "07 Provisión de bienes y servicios",
        "07.1 Comercio",
        "07.2 Alimentación y hospedaje",
        "07.3 Turismo",
        "07.4 Deporte y esparcimiento.",
        "07.5 Servicios personales",
        "07.6 Reparación de artículos de uso doméstico y personal",
        "7.7 Limpieza",
        "07.8 Servicio postal y mensajeria",
        "08 Gestión y soporte administrativo",
        "08.1 Bolsa, banca y seguros",
        "08.2 Administración",
        "08.3 Servicios legales",
        "09 Salud y protección social",
        "09.1 Servicios médicos",
        "09.2 Inspección sanitaria y del medio ambiente",
        "09.3 Seguridad social",
        "09.4 Protección de bienes y/o personas",
        "10 Comunicación",
        "10.1 Publicación",
        "10.2 Radio, cine, televisión y teatro",
        "10.3 Interpretación artística",
        "10.4 Traducción e interpretación lingüística",
        "10.5 Publicidad, propaganda y relaciones públicas",
        "11 Desarrollo y extensión del conocimiento",
        "11.1 Investigación",
        "11.2 Enseñanza",
        "11.3 Difusión cultural"
    ];

    $("#Puesto").autocomplete({
        source: puestos,
        minLength: 1,
        select: function (event, ui) {
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

        function validarCURP(input) {
            const curp = input.value;
            const curpError = document.getElementById('curpError');

            if (curp.length !== 18) {
                input.style.borderColor = 'red'; // Cambia el borde a rojo
                curpError.style.display = 'block'; // Muestra el mensaje de error
            } else {
                input.style.borderColor = ''; // Restablece el color del borde
                curpError.style.display = 'none'; // Oculta el mensaje de error
            }
        }
</script>
@endsection
