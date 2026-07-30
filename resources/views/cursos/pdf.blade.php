<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica del Curso - {{ $curso->nomenclatura }}</title>
    <style>
        @page { margin: 1.5cm; }
        body { font-family: Helvetica, Arial, sans-serif; color: #333; line-height: 1.4; font-size: 10pt; }
        .header-table { width: 100%; border-bottom: 3px solid #0d6efd; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 180px; }
        .contact-info { text-align: right; font-size: 9pt; color: #555; }
        .contact-info b { color: #0d6efd; }
        h1 { color: #212529; font-size: 18pt; margin: 0 0 5px 0; text-transform: uppercase; }
        .nomenclatura { color: #0d6efd; font-weight: bold; font-size: 13pt; margin-bottom: 15px; }
        .section { margin-bottom: 18px; page-break-inside: avoid; }
        .section-title {
            background-color: #f8f9fa; color: #0d6efd; font-size: 11pt; font-weight: bold;
            padding: 7px 10px; border-left: 5px solid #0d6efd; margin-bottom: 10px; text-transform: uppercase;
        }
        .step-status {
            float: right; font-size: 8pt; font-weight: normal; color: #666;
            background: #fff; border: 1px solid #dee2e6; padding: 2px 8px; border-radius: 10px;
        }
        .info-grid { width: 100%; border-collapse: collapse; }
        .info-grid td { padding: 5px 4px; vertical-align: top; border-bottom: 1px solid #f0f0f0; }
        .label { font-weight: bold; color: #555; width: 34%; font-size: 9pt; }
        .value { color: #212529; width: 66%; font-size: 9pt; }
        .table-custom { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .table-custom th {
            background-color: #212529; color: white; padding: 8px; font-size: 8pt;
            text-transform: uppercase; border: 1px solid #212529;
        }
        .table-custom td { padding: 8px; border: 1px solid #dee2e6; font-size: 8pt; vertical-align: top; }
        .badge { padding: 2px 7px; border-radius: 4px; font-size: 8pt; font-weight: bold; }
        .bg-primary { background-color: #0d6efd; color: white; }
        .bg-light { background-color: #e9ecef; color: #333; }
        .bg-success { background-color: #198754; color: white; }
        .bg-warning { background-color: #ffc107; color: #333; }
        .bg-danger { background-color: #dc3545; color: white; }
        .muted { color: #999; font-style: italic; }
        .footer {
            position: fixed; bottom: 0; width: 100%; text-align: center;
            font-size: 8pt; color: #999; border-top: 1px solid #eee; padding-top: 5px;
        }
    </style>
</head>
<body>
@php
    $fmtFecha = function ($fecha) {
        if (empty($fecha) || $fecha === '0000-00-00') {
            return null;
        }
        try {
            return \Carbon\Carbon::parse($fecha)->format('d/m/Y');
        } catch (\Throwable $e) {
            return null;
        }
    };

    $fmtRango = function ($inicio, $termino) use ($fmtFecha) {
        $a = $fmtFecha($inicio);
        $b = $fmtFecha($termino);
        if ($a && $b) {
            return "Del {$a} al {$b}";
        }
        return $a ?: ($b ?: null);
    };

    $fmtRecurso = function ($tipo) use ($recursos) {
        $r = $recursos->get($tipo);
        if (!$r) {
            return null;
        }
        $partes = [];
        if (!empty($r->url)) {
            $partes[] = str_contains($r->url, '/') ? basename($r->url) : $r->url;
        }
        if (!empty($r->drive_url)) {
            $partes[] = 'Drive: ' . $r->drive_url;
        }
        return count($partes) ? implode(' · ', $partes) : null;
    };

    $fmtArchivos = function ($base) use ($recursos) {
        $partes = [];
        foreach ([$base, $base . '_2'] as $tipo) {
            $r = $recursos->get($tipo);
            if ($r && !empty($r->url)) {
                $partes[] = basename($r->url);
            }
        }
        return count($partes) ? implode(' · ', $partes) : null;
    };

    $fmtEvaluacion = function ($tipo) use ($evaluaciones) {
        $e = $evaluaciones->get($tipo);
        if (!$e) {
            return null;
        }
        $partes = array_filter([
            $e->url ?? null,
            !empty($e->drive_url) ? 'Drive: ' . $e->drive_url : null,
        ]);
        return count($partes) ? implode(' · ', $partes) : null;
    };

    $fmtCert = function ($tipo, $campo = null) use ($certificaciones) {
        $c = $certificaciones->get($tipo);
        if (!$c) {
            return null;
        }
        if ($campo === 'fecha_registro') {
            return $c->fecha_registro ?? null;
        }
        if ($campo === 'firma') {
            return isset($c->tiene_firma) ? ($c->tiene_firma ? 'Sí' : 'No') : null;
        }
        $partes = array_filter([
            $c->nombre ?? null,
            !empty($c->drive_url) ? 'Drive: ' . $c->drive_url : null,
        ]);
        return count($partes) ? implode(' · ', $partes) : null;
    };

    $mostrar = function ($valor) {
        return filled($valor) ? $valor : '—';
    };

    $estadoPaso = function ($numero) use ($progreso) {
        return $progreso[$numero]['texto'] ?? 'Sin datos';
    };

    $claseEstado = function ($numero) use ($progreso) {
        $map = [
            'btn-success' => 'bg-success',
            'btn-warning' => 'bg-warning',
            'btn-danger' => 'bg-danger',
        ];
        return $map[$progreso[$numero]['class'] ?? 'btn-danger'] ?? 'bg-danger';
    };

    $modalidad = $curso->modalidadPaso2Guardada();
    $udemy = $recursos->get('udemy');
@endphp

    <table class="header-table">
        <tr>
            <td><img src="{{ public_path('images/logo4.jpg') }}" class="logo"></td>
            <td class="contact-info">
                <b>Instituto I-DEB</b><br>
                instituto.ideb@idebmexico.com<br>
                3337029639 / 3320705533
            </td>
        </tr>
    </table>

    <h1>{{ $curso->nombre ?: $curso->NombredelCurso }}</h1>
    <div class="nomenclatura">FICHA TÉCNICA: {{ $curso->nomenclatura }}</div>

    {{-- PASO 1 --}}
    <div class="section">
        <div class="section-title">
            Paso 1 — Información General
            <span class="step-status {{ $claseEstado(1) }} badge">{{ $estadoPaso(1) }}</span>
        </div>
        <table class="info-grid">
            <tr><td class="label">Descripción:</td><td class="value">{{ $mostrar($curso->descripcion ?: $curso->DescripciondeCurso) }}</td></tr>
            <tr><td class="label">Instructor(es):</td><td class="value">{{ $mostrar($curso->instructor_responsable ?: $curso->InstructorResponsable) }}</td></tr>
            <tr><td class="label">Costo:</td><td class="value">
                @if((float)($curso->costo ?: $curso->CostodelCurso) > 0)
                    <b>${{ number_format((float)($curso->costo ?: $curso->CostodelCurso), 2) }} MXN</b>
                @else
                    —
                @endif
            </td></tr>
            <tr><td class="label">Inicio desarrollo:</td><td class="value">{{ $mostrar($fmtFecha($curso->fecha_inicio ?: $curso->FechadeInicio)) }}</td></tr>
            <tr><td class="label">Término creación:</td><td class="value">{{ $mostrar($fmtFecha($curso->fecha_termino ?: $curso->FechadeTermino)) }}</td></tr>
            <tr><td class="label">Periodo impartición:</td><td class="value">{{ $mostrar($fmtRango($curso->fecha_imparticion_inicio, $curso->fecha_imparticion_termino)) }}</td></tr>
            <tr><td class="label">Duración:</td><td class="value">{{ $mostrar($curso->duracion ?: $curso->Duracioncurso) }}</td></tr>
        </table>
    </div>

    {{-- PASO 2 --}}
    <div class="section">
        <div class="section-title">
            Paso 2 — Modalidad
            <span class="step-status {{ $claseEstado(2) }} badge">{{ $estadoPaso(2) }}</span>
        </div>
        <table class="table-custom">
            <thead><tr><th>Virtual</th><th>Presencial</th><th>Mixto</th></tr></thead>
            <tbody>
                <tr>
                    <td><span class="badge {{ $modalidad === 'virtual' ? 'bg-primary' : 'bg-light' }}">{{ $modalidad === 'virtual' ? 'SÍ' : 'NO' }}</span></td>
                    <td><span class="badge {{ $modalidad === 'presencial' ? 'bg-primary' : 'bg-light' }}">{{ $modalidad === 'presencial' ? 'SÍ' : 'NO' }}</span></td>
                    <td><span class="badge {{ $modalidad === 'mixto' ? 'bg-primary' : 'bg-light' }}">{{ $modalidad === 'mixto' ? 'SÍ' : 'NO' }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- PASO 3 --}}
    <div class="section">
        <div class="section-title">
            Paso 3 — Redes y Difusión
            <span class="step-status {{ $claseEstado(3) }} badge">{{ $estadoPaso(3) }}</span>
        </div>
        <table class="info-grid">
            <tr><td class="label">Sin Fecha:</td><td class="value">{{ $mostrar($fmtRecurso('sin_fecha')) }}</td></tr>
            <tr><td class="label">Archivos Sin Fecha:</td><td class="value">{{ $mostrar($fmtArchivos('sin_fecha_archivo')) }}</td></tr>
            <tr><td class="label">Facebook:</td><td class="value">{{ $mostrar($fmtRecurso('facebook')) }}</td></tr>
            <tr><td class="label">Archivos Facebook:</td><td class="value">{{ $mostrar($fmtArchivos('facebook_archivo')) }}</td></tr>
            <tr><td class="label">LinkedIn:</td><td class="value">{{ $mostrar($fmtRecurso('linkedin')) }}</td></tr>
            <tr><td class="label">Archivos LinkedIn:</td><td class="value">{{ $mostrar($fmtArchivos('linkedin_archivo')) }}</td></tr>
            <tr><td class="label">Instagram:</td><td class="value">{{ $mostrar($fmtRecurso('instagram')) }}</td></tr>
            <tr><td class="label">Archivos Instagram:</td><td class="value">{{ $mostrar($fmtArchivos('instagram_archivo')) }}</td></tr>
        </table>
    </div>

    {{-- PASO 4 --}}
    <div class="section">
        <div class="section-title">
            Paso 4 — Planeación Académica
            <span class="step-status {{ $claseEstado(4) }} badge">{{ $estadoPaso(4) }}</span>
        </div>
        <table class="info-grid">
            <tr><td class="label">Temario:</td><td class="value">{{ $mostrar($fmtRecurso('temario')) }}</td></tr>
            <tr><td class="label">Archivos Temario:</td><td class="value">{{ $mostrar($fmtArchivos('temario_archivo')) }}</td></tr>
            <tr><td class="label">Itinerario:</td><td class="value">{{ $mostrar($fmtRecurso('itinerario')) }}</td></tr>
            <tr><td class="label">Archivos Itinerario:</td><td class="value">{{ $mostrar($fmtArchivos('itinerario_archivo')) }}</td></tr>
            <tr><td class="label">Planeación:</td><td class="value">{{ $mostrar($fmtRecurso('planeacion')) }}</td></tr>
            <tr><td class="label">Archivos Planeación:</td><td class="value">{{ $mostrar($fmtArchivos('planeacion_archivo')) }}</td></tr>
        </table>
    </div>

    {{-- PASO 5 --}}
    <div class="section">
        <div class="section-title">
            Paso 5 — Materiales
            <span class="step-status {{ $claseEstado(5) }} badge">{{ $estadoPaso(5) }}</span>
        </div>
        <table class="info-grid">
            <tr><td class="label">Material Digital:</td><td class="value">{{ $mostrar($fmtRecurso('digital')) }}</td></tr>
            <tr><td class="label">Archivos Digital:</td><td class="value">{{ $mostrar($fmtArchivos('digital_archivo')) }}</td></tr>
            <tr><td class="label">Material Impreso:</td><td class="value">{{ $mostrar($fmtRecurso('impreso')) }}</td></tr>
            <tr><td class="label">Archivos Impreso:</td><td class="value">{{ $mostrar($fmtArchivos('impreso_archivo')) }}</td></tr>
            <tr><td class="label">Presentación:</td><td class="value">{{ $mostrar($fmtRecurso('presentacion')) }}</td></tr>
            <tr><td class="label">Archivos Presentación:</td><td class="value">{{ $mostrar($fmtArchivos('presentacion_archivo')) }}</td></tr>
        </table>
    </div>

    {{-- PASO 6 --}}
    <div class="section">
        <div class="section-title">
            Paso 6 — Evaluación y Certificación
            <span class="step-status {{ $claseEstado(6) }} badge">{{ $estadoPaso(6) }}</span>
        </div>
        <table class="info-grid">
            <tr><td class="label">Evaluación Diagnóstica:</td><td class="value">{{ $mostrar($fmtEvaluacion('diagnostica')) }}</td></tr>
            <tr><td class="label">Archivos Diagnóstica:</td><td class="value">{{ $mostrar($fmtArchivos('diagnostica_archivo')) }}</td></tr>
            <tr><td class="label">Evaluación Satisfacción:</td><td class="value">{{ $mostrar($fmtEvaluacion('satisfaccion')) }}</td></tr>
            <tr><td class="label">Archivos Satisfacción:</td><td class="value">{{ $mostrar($fmtArchivos('satisfaccion_archivo')) }}</td></tr>
            <tr><td class="label">Evaluación Final:</td><td class="value">{{ $mostrar($fmtEvaluacion('final')) }}</td></tr>
            <tr><td class="label">Archivos Final:</td><td class="value">{{ $mostrar($fmtArchivos('final_archivo')) }}</td></tr>
            <tr><td class="label">DC3:</td><td class="value">{{ $mostrar($fmtCert('dc3')) }}</td></tr>
        </table>
    </div>

    {{-- PASO 7 --}}
    <div class="section">
        <div class="section-title">
            Paso 7 — STPS, Certificados y Udemy
            <span class="step-status {{ $claseEstado(7) }} badge">{{ $estadoPaso(7) }}</span>
        </div>
        <table class="info-grid">
            <tr><td class="label">Fecha Registro STPS:</td><td class="value">{{ $mostrar($fmtFecha($fmtCert('fecha_registro', 'fecha_registro'))) }}</td></tr>
            <tr><td class="label">Formato DC5:</td><td class="value">{{ $mostrar($fmtCert('dc5')) }}</td></tr>
            <tr><td class="label">DC5 tiene firma:</td><td class="value">{{ $mostrar($fmtCert('dc5', 'firma')) }}</td></tr>
            <tr><td class="label">Archivos DC5:</td><td class="value">{{ $mostrar($fmtArchivos('dc5_archivo')) }}</td></tr>
            <tr><td class="label">Certificado Comprobación:</td><td class="value">{{ $mostrar($fmtCert('certificado_comprobacion')) }}</td></tr>
            <tr><td class="label">Archivos Certificado:</td><td class="value">{{ $mostrar($fmtArchivos('certificado_archivo')) }}</td></tr>
            <tr><td class="label">Carta Poder:</td><td class="value">{{ $mostrar($fmtCert('carta_poder')) }}</td></tr>
            <tr><td class="label">Carta Poder tiene firma:</td><td class="value">{{ $mostrar($fmtCert('carta_poder', 'firma')) }}</td></tr>
            <tr><td class="label">Archivos Carta Poder:</td><td class="value">{{ $mostrar($fmtArchivos('carta_poder_archivo')) }}</td></tr>
            <tr><td class="label">Udemy:</td><td class="value">
                @if($udemy && (!empty($udemy->url) || !empty($udemy->drive_url)))
                    {{ $mostrar(trim(($udemy->url ?? '') . (!empty($udemy->drive_url) ? ' · Drive: ' . $udemy->drive_url : ''))) }}
                @else
                    —
                @endif
            </td></tr>
        </table>
    </div>

    <div class="footer">
        Ficha generada automáticamente por el Sistema de Gestión de Cursos - Instituto I-DEB | {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
