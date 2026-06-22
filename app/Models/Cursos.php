<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Cursos extends Model
{
    protected $fillable = [
        'parent_id',
        'nomenclatura',
        'nombre',
        'descripcion',
        'costo',
        'instructor_responsable',
        'fecha_inicio',
        'fecha_termino',
        'virtual',
        'presencial',
        'mixto',
        'sin_fecha',
        'drive_sin_fecha',
        'facebook',
        'drive_facebook',
        'linkedin',
        'drive_linkedin',
        'instagram',
        'drive_instagram',
        'temario',
        'drive_temario',
        'itinerario',
        'drive_itinerario',
        'planeacion',
        'drive_planeacion',
        'digital',
        'drive_digital',
        'impreso_presentable',
        'presentacion',
        'drive_presentacion',
        'evaluacion_diagnostica',
        'evaluacion_satisfaccion',
        'evaluacion_final',
        'dc3',
        'fecha_registro_stps',
        'formato_dc5',
        'formato_dc5_tiene_firma',
        'certificado_comprobacion',
        'drive_certificado_comprobacion',
        'carta_poder_tiene_firma',
        'drive_carta_poder',
        'udemy',
        'enlace_udemy',
        'status',
        'duracion',
        // RUTAS DE ARCHIVOS - PASO 3
        'ruta_sin_fecha',
        'ruta_facebook',
        'ruta_linkedin',
        'ruta_instagram',
        // RUTAS DE ARCHIVOS - PASO 4
        'ruta_temario',
        'ruta_itinerario',
        'ruta_planeacion',
        // RUTAS DE ARCHIVOS - PASO 5
        'ruta_digital',
        'ruta_impreso_presentable',
        // RUTAS DE ARCHIVOS - PASO 6
        'ruta_presentacion',
        'ruta_evaluacion_diagnostica',
        'ruta_evaluacion_satisfaccion',
        'ruta_evaluacion_final',
        // RUTAS DE ARCHIVOS - PASO 7
        'ruta_formato_dc5',
        'ruta_certificado_comprobacion',
        'ruta_carta_poder',
        'ruta_udemy',
    ];

    public function subcursos()
    {
        return $this->hasMany(Cursos::class, 'parent_id');
    }

    public function cursoPadre()
    {
        return $this->belongsTo(Cursos::class, 'parent_id');
    }

    // Accessors para mantener compatibilidad con la vista (Mapeo total)
    public function getNomenclaturaAttribute() { return $this->attributes['nomenclatura'] ?? ''; }
    public function getNombredelCursoAttribute() { return $this->attributes['nombre'] ?? ''; }
    public function getDescripciondeCursoAttribute() { return $this->attributes['descripcion'] ?? ''; }
    public function getCostodelCursoAttribute() { return $this->attributes['costo'] ?? ''; }
    public function getInstructorResponsableAttribute() { return $this->attributes['instructor_responsable'] ?? ''; }
    public function getFechadeInicioAttribute() { return $this->attributes['fecha_inicio'] ?? ''; }
    public function getFechadeTerminoAttribute() { return $this->attributes['fecha_termino'] ?? ''; }
    public function getVirtualAttribute() { return $this->attributes['virtual'] ?? ''; }
    public function getPresencialAttribute() { return $this->attributes['presencial'] ?? ''; }
    public function getMixtoAttribute() { return $this->attributes['mixto'] ?? ''; }
    public function getSinFechaAttribute() { return $this->attributes['sin_fecha'] ?? ''; }
    public function getDriveSinFechaAttribute() { return $this->attributes['drive_sin_fecha'] ?? ''; }
    public function getFacebookAttribute() { return $this->attributes['facebook'] ?? ''; }
    public function getDriveFacebookAttribute() { return $this->attributes['drive_facebook'] ?? ''; }
    public function getLinkedinAttribute() { return $this->attributes['linkedin'] ?? ''; }
    public function getDriveLinkedinAttribute() { return $this->attributes['drive_linkedin'] ?? ''; }
    public function getInstagramAttribute() { return $this->attributes['instagram'] ?? ''; }
    public function getDriveInstagramAttribute() { return $this->attributes['drive_instagram'] ?? ''; }
    public function getTemarioAttribute() { return $this->attributes['temario'] ?? ''; }
    public function getDriveTemarioAttribute() { return $this->attributes['drive_temario'] ?? ''; }
    public function getItinerarioAttribute() { return $this->attributes['itinerario'] ?? ''; }
    public function getDriveItinerarioAttribute() { return $this->attributes['drive_itinerario'] ?? ''; }
    public function getPlaneaciónAttribute() { return $this->attributes['planeacion'] ?? ''; }
    public function getDrivePlaneaciónAttribute() { return $this->attributes['drive_planeacion'] ?? ''; }
    public function getDigitalAttribute() { return $this->attributes['digital'] ?? ''; }
    public function getDriveDigitalAttribute() { return $this->attributes['drive_digital'] ?? ''; }
    public function getImpreso_PresentableAttribute() { return $this->attributes['impreso_presentable'] ?? ''; }
    public function getPresentaciónAttribute() { return $this->attributes['presentacion'] ?? ''; }
    public function getDrivePresentacionAttribute() { return $this->attributes['drive_presentacion'] ?? ''; }
    public function getEvaluación_diagnosticaAttribute() { return $this->attributes['evaluacion_diagnostica'] ?? ''; }
    public function getEvaluaciondeSatisfacciónAttribute() { return $this->attributes['evaluacion_satisfaccion'] ?? ''; }
    public function getEvaluacionFinalAttribute() { return $this->attributes['evaluacion_final'] ?? ''; }
    public function getDC3Attribute() { return $this->attributes['dc3'] ?? ''; }
    public function getFechadeRegistro_STPSAttribute() { return $this->attributes['fecha_registro_stps'] ?? ''; }
    public function getFormato_DC5Attribute() { return $this->attributes['formato_dc5'] ?? ''; }
    public function getFormato_DC5_TienefirmaAttribute() { return $this->attributes['formato_dc5_tiene_firma'] ?? ''; }
    public function getCertificadodecomprobacionAttribute() { return $this->attributes['certificado_comprobacion'] ?? ''; }
    public function getDrivedeCertificadodecomprobacionAttribute() { return $this->attributes['drive_certificado_comprobacion'] ?? ''; }
    public function getCartapoder_tienefirmaAttribute() { return $this->attributes['carta_poder_tiene_firma'] ?? ''; }
    public function getDriveCartapoderAttribute() { return $this->attributes['drive_carta_poder'] ?? ''; }
    public function getUDEMYAttribute() { return $this->attributes['udemy'] ?? ''; }
    public function getDuracioncursoAttribute() { return $this->attributes['duracion'] ?? ''; }
    public function getRutaSinFechaAttribute() { return $this->attributes['ruta_sin_fecha'] ?? ''; }
    public function getRutaFacebookAttribute() { return $this->attributes['ruta_facebook'] ?? ''; }
    public function getRutaLinkedinAttribute() { return $this->attributes['ruta_linkedin'] ?? ''; }
    public function getRutaInstagramAttribute() { return $this->attributes['ruta_instagram'] ?? ''; }
    public function getRutaTemarioAttribute() { return $this->attributes['ruta_temario'] ?? ''; }
    public function getRutaItinerarioAttribute() { return $this->attributes['ruta_itinerario'] ?? ''; }
    public function getRutaPlaneacionAttribute() { return $this->attributes['ruta_planeacion'] ?? ''; }
    public function getRutaDigitalAttribute() { return $this->attributes['ruta_digital'] ?? ''; }
    public function getRutaImpresoPresentableAttribute() { return $this->attributes['ruta_impreso_presentable'] ?? ''; }
    public function getRutaPresentacionAttribute() { return $this->attributes['ruta_presentacion'] ?? ''; }
    public function getRutaEvaluacionDiagnosticaAttribute() { return $this->attributes['ruta_evaluacion_diagnostica'] ?? ''; }
    public function getRutaEvaluacionSatisfaccionAttribute() { return $this->attributes['ruta_evaluacion_satisfaccion'] ?? ''; }
    public function getRutaEvaluacionFinalAttribute() { return $this->attributes['ruta_evaluacion_final'] ?? ''; }
    public function getRutaFormatoDc5Attribute() { return $this->attributes['ruta_formato_dc5'] ?? ''; }
    public function getRutaCertificadoComprobacionAttribute() { return $this->attributes['ruta_certificado_comprobacion'] ?? ''; }
    public function getRutaCartaPoderAttribute() { return $this->attributes['ruta_carta_poder'] ?? ''; }
    public function getRutaUdemyAttribute() { return $this->attributes['ruta_udemy'] ?? ''; }

    protected $dates = [
        'fecha_inicio',
        'fecha_termino',
        'fecha_registro_stps'
    ];

    public function getEstatusProgresoAttribute()
    {
        $campos = [
            'nomenclatura', 'nombre', 'descripcion', 'costo', 'instructor_responsable', 'fecha_inicio', 'fecha_termino', 'duracion',
            'virtual', 'presencial', 'mixto', 'sin_fecha', 'facebook', 'linkedin', 'instagram', 'temario', 'itinerario', 'planeacion',
            'digital', 'impreso_presentable', 'presentacion', 'evaluacion_diagnostica', 'evaluacion_satisfaccion', 'evaluacion_final', 'dc3',
            'fecha_registro_stps', 'formato_dc5', 'certificado_comprobacion', 'udemy'
        ];

        $llenos = 0;
        foreach ($campos as $campo) {
            if (!empty($this->attributes[$campo])) $llenos++;
        }

        $porcentaje = (count($campos) > 0) ? ($llenos / count($campos)) * 100 : 0;

        if ($porcentaje == 100) {
            return ['texto' => 'Completado', 'color' => 'bg-success'];
        } elseif ($porcentaje >= 30) {
            return ['texto' => 'En progreso', 'color' => 'bg-warning'];
        } else {
            return ['texto' => 'Pendiente de actualización', 'color' => 'bg-danger'];
        }
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'curso_id');
    }

    public function getFechaInicio($id)
    {
        $curso = Cursos::findOrFail($id);
        return response()->json(['fecha_inicio' => $curso->fecha_inicio]);
    }

    public function participantes()
    {
        return $this->belongsToMany(
            Participantes::class,
            'inscripciones',
            'curso_id',
            'participante_id'
        );
    }
}
