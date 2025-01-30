@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Configuraciones</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('configuraciones.store') }}" method="POST">
        @csrf

        <h2>Parámetros Generales</h2>
        <div class="form-group">
            <label for="timezone">Zona Horaria</label>
            <select name="timezone" id="timezone" class="form-control">
                <option value="UTC" {{ $currentTimezone == 'UTC' ? 'selected' : '' }}>UTC</option>
                <option value="America/Mexico_City" {{ $currentTimezone == 'America/Mexico_City' ? 'selected' : '' }}>México</option>
                <option value="Europe/Madrid" {{ $currentTimezone == 'Europe/Madrid' ? 'selected' : '' }}>España</option>
            </select>
        </div>

        <div class="form-group">
            <label for="language">Idioma</label>
            <select name="language" id="language" class="form-control">
                <option value="es" {{ $currentLanguage == 'es' ? 'selected' : '' }}>Español</option>
                <option value="en" {{ $currentLanguage == 'en' ? 'selected' : '' }}>Inglés</option>
            </select>
        </div>

        <div class="form-group">
            <label for="currency">Moneda</label>
            <select name="currency" id="currency" class="form-control">
                <option value="MXN" {{ $currentCurrency == 'MXN' ? 'selected' : '' }}>Peso Mexicano (MXN)</option>
                <option value="USD" {{ $currentCurrency == 'USD' ? 'selected' : '' }}>Dólar Estadounidense (USD)</option>
                <option value="EUR" {{ $currentCurrency == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
            </select>
        </div>

        <h2>Configuración de Base de Datos</h2>
        <div class="form-group">
            <label for="db_connection">Tipo de Conexión</label>
            <select name="db_connection" id="db_connection" class="form-control">
                <option value="mysql" {{ $currentDbConnection == 'mysql' ? 'selected' : '' }}>MySQL</option>
                <option value="pgsql" {{ $currentDbConnection == 'pgsql' ? 'selected' : '' }}>PostgreSQL</option>
                <option value="sqlite" {{ $currentDbConnection == 'sqlite' ? 'selected' : '' }}>SQLite</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>
@endsection
