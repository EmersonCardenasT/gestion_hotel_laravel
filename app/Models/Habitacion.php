<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    /** @use HasFactory<\Database\Factories\HabitacionFactory> */
    use HasFactory;
    
    protected $table = 'habitaciones';
    protected $primaryKey = 'id_habitacion';

    protected $fillable = [
        'numero',
        'id_tipo',
        'piso',
        'estado',
        'observaciones'
    ];

    public function tipo()
    {
        return $this->belongsTo(
            TipoHabitacion::class,
            'id_tipo'
        );
    }
}
