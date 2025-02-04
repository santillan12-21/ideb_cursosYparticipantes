<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'inscripciones';

    // Desactivar timestamps si no usas las columnas created_at y updated_at
    public $timestamps = false;

    // Definir las relaciones
    public function participante()
    {
        return $this->belongsTo(Participantes::class, 'participante_id');
    }

    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'curso_id');
    }
}
