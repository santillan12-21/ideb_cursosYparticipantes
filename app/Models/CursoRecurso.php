<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoRecurso extends Model
{
    protected $table = 'curso_recursos';

    protected $fillable = [
        'curso_id',
        'tipo_recurso',
        'nombre',
        'url',
        'drive_url',
        'descripcion'
    ];

    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'curso_id');
    }
}