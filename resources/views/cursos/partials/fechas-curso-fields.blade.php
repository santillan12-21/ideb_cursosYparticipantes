<div class="col-12">
    <hr class="my-2">
    <p class="small text-muted mb-2 fw-semibold text-uppercase">Desarrollo del curso</p>
</div>

<div class="col-md-6">
    <label for="FechadeInicio" class="form-label">
        Fecha de inicio de desarrollo del curso
        <span class="estado-indicador" id="estado-FechadeInicio"></span>
    </label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        <input type="date" name="FechadeInicio" id="FechadeInicio"
            class="form-control @error('FechadeInicio') is-invalid @enderror"
            value="{{ old('FechadeInicio', $fechaInicio ?? '') }}"
            oninput="validarCampo(this)"
            onchange="validarCampo(this)">
        @error('FechadeInicio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <label for="FechadeTermino" class="form-label">
        Fecha de término de creación del curso
        <span class="estado-indicador" id="estado-FechadeTermino"></span>
    </label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
        <input type="date" name="FechadeTermino" id="FechadeTermino"
            class="form-control @error('FechadeTermino') is-invalid @enderror"
            value="{{ old('FechadeTermino', $fechaTermino ?? '') }}"
            oninput="validarCampo(this)"
            onchange="validarCampo(this)">
        @error('FechadeTermino')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-12">
    <hr class="my-2">
    <p class="small text-muted mb-2 fw-semibold text-uppercase">Periodo de impartición</p>
</div>

<div class="col-md-6">
    <label for="FechaImparticionInicio" class="form-label">
        Inicio de impartición
        <span class="estado-indicador" id="estado-FechaImparticionInicio"></span>
    </label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
        <input type="date" name="FechaImparticionInicio" id="FechaImparticionInicio"
            class="form-control @error('FechaImparticionInicio') is-invalid @enderror"
            value="{{ old('FechaImparticionInicio', $fechaImparticionInicio ?? '') }}"
            oninput="validarCampo(this)"
            onchange="validarCampo(this)">
        @error('FechaImparticionInicio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <label for="FechaImparticionTermino" class="form-label">
        Término de impartición
        <span class="estado-indicador" id="estado-FechaImparticionTermino"></span>
    </label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-flag-checkered"></i></span>
        <input type="date" name="FechaImparticionTermino" id="FechaImparticionTermino"
            class="form-control @error('FechaImparticionTermino') is-invalid @enderror"
            value="{{ old('FechaImparticionTermino', $fechaImparticionTermino ?? '') }}"
            oninput="validarCampo(this)"
            onchange="validarCampo(this)">
        @error('FechaImparticionTermino')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
