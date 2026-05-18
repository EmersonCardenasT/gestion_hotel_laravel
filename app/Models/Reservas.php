<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'id_habitacion',
        'fecha_ingreso',
        'fecha_salida',
        'numero_huespedes',
        'adelanto',
        'notas',
        'estado',
    ];

    // Relación con Clientea
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con Habitación
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }
}
