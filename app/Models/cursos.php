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

    public function participantes()
    {
        return $this->belongsToMany(Participantes::class, 'participante_curso', 'curso_id', 'participante_id')
                    ->withPivot('FechadelCurso');
    }
}
