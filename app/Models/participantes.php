<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participantes extends Model
{
    use HasFactory;

    protected $table = 'participantes';

    // Indicamos que la clave primaria es 'N'
    protected $primaryKey = 'N';

    // Especificamos que la clave primaria no es autoincrementable
    public $incrementing = false;

    // Indicamos que la clave primaria es de tipo string
    protected $keyType = 'string';

    protected $fillable = [
        'N',
        'NombredelPostulante',
        'Correo',
        'Telefono',
        'Edad',
        'Direccion',
        'Escolaridad',
        'Curp',
        'RazonSocial',
        'Empresa',
        'RFCEmpresa',
        'Puesto',
        'Pago',
        'EstadoDePago',
        'FechadelCurso'
    ];

    public function cursos()
    {
        return $this->belongsToMany(Cursos::class, 'participante_curso', 'participante_id', 'curso_id')
                    ->withPivot('FechadelCurso');
    }
}
