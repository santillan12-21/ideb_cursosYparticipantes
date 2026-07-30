@php
    $instructoresLista = $instructores ?? [''];
    if (!is_array($instructoresLista) || count($instructoresLista) === 0) {
        $instructoresLista = [''];
    }
@endphp

<div class="col-12" id="instructores-section">
    <label class="form-label">
        Instructores
        <span class="estado-indicador" id="estado-instructores"></span>
    </label>
    <small class="text-muted d-block mb-2">Agrega uno o más instructores si el curso o subcurso lo requiere.</small>

    <div id="instructores-container">
        @foreach ($instructoresLista as $index => $nombreInstructor)
            <div class="input-group mb-2 instructor-row">
                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                <input type="text"
                    name="Instructores[]"
                    class="form-control instructor-input"
                    placeholder="Nombre del instructor"
                    value="{{ is_array(old('Instructores')) ? (old('Instructores')[$index] ?? '') : $nombreInstructor }}"
                    oninput="validarCampo(this); actualizarEstadoInstructores();"
                    onchange="validarCampo(this); actualizarEstadoInstructores();">
                <button type="button"
                    class="btn btn-outline-danger btn-quitar-instructor"
                    title="Quitar instructor"
                    @if(count($instructoresLista) <= 1) disabled @endif>
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        @endforeach
    </div>

    @if ($errors->has('Instructores') || $errors->has('Instructores.*'))
        <div class="text-danger small mt-1">
            {{ $errors->first('Instructores') ?: $errors->first('Instructores.*') }}
        </div>
    @endif

    <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="btnAgregarInstructor">
        <i class="fas fa-plus me-1"></i> Agregar instructor
    </button>
</div>

<style>
    #instructores-section .btn-quitar-instructor {
        min-width: 42px;
    }
</style>

<script>
function actualizarEstadoInstructores() {
    const indicador = document.getElementById('estado-instructores');
    if (!indicador) {
        return;
    }

    const valores = Array.from(document.querySelectorAll('#instructores-container .instructor-input'))
        .map(input => input.value.trim())
        .filter(valor => valor !== '');

    indicador.classList.remove('estado-verde', 'estado-amarillo', 'estado-rojo');

    if (valores.length === 0) {
        indicador.classList.add('estado-amarillo');
        indicador.title = 'Sin instructores registrados';
        return;
    }

    const incompletos = valores.some(valor => valor.length < 3);
    if (incompletos) {
        indicador.classList.add('estado-amarillo');
        indicador.title = 'Hay instructores incompletos';
        return;
    }

    indicador.classList.add('estado-verde');
    indicador.title = `${valores.length} instructor(es) registrado(s)`;
}

function actualizarBotonesInstructores() {
    const filas = document.querySelectorAll('#instructores-container .instructor-row');
    const soloUna = filas.length <= 1;

    filas.forEach(fila => {
        const boton = fila.querySelector('.btn-quitar-instructor');
        if (boton) {
            boton.disabled = soloUna;
        }
    });
}

function initInstructoresPaso1() {
    const contenedor = document.getElementById('instructores-container');
    const botonAgregar = document.getElementById('btnAgregarInstructor');

    if (!contenedor || !botonAgregar) {
        return;
    }

    botonAgregar.addEventListener('click', function () {
        const fila = document.createElement('div');
        fila.className = 'input-group mb-2 instructor-row';
        fila.innerHTML = `
            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
            <input type="text"
                name="Instructores[]"
                class="form-control instructor-input"
                placeholder="Nombre del instructor"
                oninput="validarCampo(this); actualizarEstadoInstructores();"
                onchange="validarCampo(this); actualizarEstadoInstructores();">
            <button type="button" class="btn btn-outline-danger btn-quitar-instructor" title="Quitar instructor">
                <i class="fas fa-minus"></i>
            </button>
        `;
        contenedor.appendChild(fila);
        actualizarBotonesInstructores();
        fila.querySelector('input')?.focus();
    });

    contenedor.addEventListener('click', function (event) {
        const boton = event.target.closest('.btn-quitar-instructor');
        if (!boton || boton.disabled) {
            return;
        }

        const fila = boton.closest('.instructor-row');
        if (!fila) {
            return;
        }

        fila.remove();
        actualizarBotonesInstructores();
        actualizarEstadoInstructores();
        actualizarContadores();
        actualizarEstadoGeneral();
    });

    document.querySelectorAll('#instructores-container .instructor-input').forEach(input => {
        validarCampo(input);
    });

    actualizarBotonesInstructores();
    actualizarEstadoInstructores();
}
</script>
