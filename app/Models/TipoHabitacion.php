<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    /** @use HasFactory<\Database\Factories\TipoHabitacionFactory> */
    use HasFactory;

    protected $table = 'tipos_habitacion';
    protected $primaryKey = 'id_tipo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'precio_base',
        'comodidades',
        'activo'
    ];

    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class,'id_tipo');
    }
}
