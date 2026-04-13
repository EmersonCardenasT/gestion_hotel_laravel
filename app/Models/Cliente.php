<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;

    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'email',
        'direccion',
        'pais'
    ];

    // public function reservas()
    // {
    //     return $this->hasMany(Reserva::class,'id_cliente');
    // }

}
