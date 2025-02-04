<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class cursos extends Model
{
    protected $fillable = [
       'Nomenclatura',
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
