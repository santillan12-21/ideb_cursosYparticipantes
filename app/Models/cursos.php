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
class cursos extends Model
{
    protected $fillable = [
       'Nomenclatura',
        'parent_id',
        'NombredelCurso',
        'DescripciondeCurso',
        'CostodelCurso',
        'InstructorResponsable',
        'FechadeInicio',
        'FechadeTermino',
        'Virtual',
        'Presencial',
        'Mixto',
        'SinFecha',
        'DriveSinFecha',
        'Facebook',
        'DriveFacebook',
        'Linkedin',
        'DriveLinkedin',
        'Instagram',
        'DriveInstagram',
        'Temario',
        'DriveTemario',
        'Itinerario',
        'DriveItinerario',
        'Planeación',
        'DrivePlaneación',
        'Digital',
        'DriveDigital',
        'Impreso_Presentable',
        'Presentación',
        'Evaluación_diagnostica',
        'EvaluaciondeSatisfacción',
        'EvaluacionFinal',
        'DC3',
        'FechadeRegistro_STPS',
        'Formato_DC5',
        'Formato_DC5_Tienefirma',
        'Certificadodecomprobacion',
        'DrivedeCertificadodecomprobacion',
        'Cartapoder_tienefirma',
        'DriveCartapoder',
        'UDEMY',
        'Duracioncurso',
        'status',
    ];

    protected $dates = [
        'FechadeInicio',
        'FechadeTermino',
        'FechadeRegistro_STPS'
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'participante_id');
    }

    public function getFechaInicio($id)
    {
        $curso = Cursos::findOrFail($id);
        return response()->json(['fecha_inicio' => $curso->FechadeInicio]);
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

    public function subcursos()
    {
        return $this->hasMany(Cursos::class, 'parent_id');
    }

    public function cursoPadre()
    {
        return $this->belongsTo(Cursos::class, 'parent_id');
    }

    public function ruta()
{
    return $this->hasOne(RutaLocal::class, 'id_cursos');
}

}
