<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estancia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'habitacion_id',
        'reserva_id',
        'fecha_checkin',
        'fecha_checkout',
        'adultos',
        'ninos',
        'tarifa_noche',
        'noches',
        'subtotal',
        'total',
        'estado',
        'observaciones',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id', 'id_habitacion');
    }

    public function reserva()
    {
        return $this->belongsTo(Reservas::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
