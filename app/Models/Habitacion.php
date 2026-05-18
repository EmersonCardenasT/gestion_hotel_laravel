<?php

namespace App\Models;

use Database\Factories\HabitacionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    /** @use HasFactory<HabitacionFactory> */
    use HasFactory;

    protected $table = 'habitaciones';

    protected $primaryKey = 'id_habitacion';

    protected $fillable = [
        'numero',
        'id_tipo',
        'precio_base',
        'piso',
        'estado',
        'observaciones',
        'imagen',
    ];

    public function tipoHabitacion()
    {
        return $this->belongsTo(TipoHabitacion::class, 'id_tipo', 'id_tipo');
    }

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'id_habitacion', 'id_habitacion');
    }
}
