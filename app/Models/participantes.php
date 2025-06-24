<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string|null $N
 * @property string $NombredelPostulante
 * @property string $Correo
 * @property string $Telefono
 * @property string $Edad
 * @property string $Direccion
 * @property string $Escolaridad
 * @property string $Curp
 * @property string $RazónSocial
 * @property string $Empresa
 * @property string $RFCEmpresa
 * @property string $Puesto
 * @property string $Pago
 * @property string $EstadoDePago
 * @property string $FechadelCurso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\cursos> $cursos
 * @property-read int|null $cursos_count
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Inscripcion> $inscripciones
 * @property-read int|null $inscripciones_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereEdad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereEscolaridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereEstadoDePago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereFechadelCurso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereNombredelPostulante($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes wherePago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes wherePuesto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereRFCEmpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereRazónSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|participantes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        'Ocupacion',
        'Puesto',
        'Pago',
        'EstadoDePago',
        'FechadelCurso',
        'estatus'
    ];

    public function setEstadoDePagoAttribute($value)
    {
        // Lista de valores permitidos
        $allowedValues = ['Pendiente', 'Pagado', 'Anticipo', 'Cancelado'];

        // Si el valor está en la lista permitida, guárdalo; de lo contrario, usa un valor predeterminado
        if (in_array($value, $allowedValues)) {
            $this->attributes['EstadoDePago'] = $value;

            // Si el estado de pago es "Cancelado", establecer el campo Pago en 0
            if ($value === 'Cancelado') {
                $this->attributes['Pago'] = 0;
            }
        } else {
            $this->attributes['EstadoDePago'] = 'Pagado'; // Valor predeterminado
        }
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'participante_id');
    }

    public function getPagoAttribute($value)
    {
        return $value ?? '';
    }

    public function getEstadoDePagoAttribute($value)
    {
        return $value ?? 'Pago Pendiente';
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
