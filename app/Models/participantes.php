<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participantes extends Model
{
    use HasFactory;

    protected $table = 'participantes';

    protected $primaryKey = 'id';
    public $incrementing = true; // Asegura que el ID sea autoincremental


    protected $fillable = [
        'N',
        'NombredelPostulante',
        'Correo',
        'Telefono',
        'Edad',
        'Direccion',
        'Escolaridad',
        'Curp',
        'RazónSocial',
        'Empresa',
        'RFCEmpresa',
        'Puesto',
        'Pago',
        'EstadoDePago',
        'FechadelCurso'
    ];


    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'participante_id');
    }

    public function cursos()
    {
        return $this->belongsToMany(
            Cursos::class,         // Modelo relacionado
            'inscripciones',       // Tabla intermedia
            'participante_id',     // Clave foránea en la tabla intermedia para participantes
            'curso_id'             // Clave foránea en la tabla intermedia para cursos
        );
    }
}
