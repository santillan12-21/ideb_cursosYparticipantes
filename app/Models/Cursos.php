<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $Nomenclatura
 * @property string $NombredelCurso
 * @property string $DescripciondeCurso
 * @property string $CostodelCurso
 * @property string $InstructorResponsable
 * @property string $FechadeInicio
 * @property string $FechadeTermino
 * @property string $Virtual
 * @property string $Presencial
 * @property string $Mixto
 * @property string $SinFecha
 * @property string $DriveSinFecha
 * @property string $Facebook
 * @property string $DriveFacebook
 * @property string $Linkedin
 * @property string $DriveLinkedin
 * @property string $Instagram
 * @property string $DriveInstagram
 * @property string $Temario
 * @property string $DriveTemario
 * @property string $Itinerario
 * @property string $DriveItinerario
 * @property string $Planeación
 * @property string $DrivePlaneación
 * @property string $Digital
 * @property string $DriveDigital
 * @property string $Impreso_Presentable
 * @property string $Presentación
 * @property string $Evaluación_diagnostica
 * @property string $EvaluaciondeSatisfacción
 * @property string $EvaluacionFinal
 * @property string $DC3
 * @property string|null $FechadeRegistro_STPS
 * @property string $Formato_DC5
 * @property string $Formato_DC5_Tienefirma
 * @property string $Certificadodecomprobacion
 * @property string $DrivedeCertificadodecomprobacion
 * @property string $Cartapoder_tienefirma
 * @property string $DriveCartapoder
 * @property string $UDEMY
 * @property string $EnlaceUDEMY
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $Duracioncurso
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Inscripcion> $inscripciones
 * @property-read int|null $inscripciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\participantes> $participantes
 * @property-read int|null $participantes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereCartapoderTienefirma($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereCertificadodecomprobacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereCostodelCurso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDC3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDescripciondeCurso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDigital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveCartapoder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveDigital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveItinerario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDrivePlaneación($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveSinFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDriveTemario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDrivedeCertificadodecomprobacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereDuracioncurso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereEnlaceUDEMY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereEvaluacionFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereEvaluaciondeSatisfacción($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereEvaluaciónDiagnostica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereFechadeInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereFechadeRegistroSTPS($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereFechadeTermino($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereFormatoDC5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereFormatoDC5Tienefirma($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereImpresoPresentable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereInstructorResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereItinerario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereMixto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereNombredelCurso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereNomenclatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos wherePlaneación($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos wherePresencial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos wherePresentación($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereSinFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereTemario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereUDEMY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|cursos whereVirtual($value)
 * @mixin \Eloquent
 */
class Cursos extends Model
{
    protected $fillable = [
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
        'duracion'
    ];

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
    public function getDriveSinFechaAttribute() { return $this->attributes['drive_sin_fecha'] ?? ''; }

    protected $dates = [
        'fecha_inicio',
        'fecha_termino',
        'fecha_registro_stps'
    ];

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
            Participantes::class,  // Modelo relacionado
            'inscripciones',       // Tabla intermedia
            'curso_id',            // Clave foránea en la tabla intermedia para cursos
            'participante_id'      // Clave foránea en la tabla intermedia para participantes
        );
    }
}
