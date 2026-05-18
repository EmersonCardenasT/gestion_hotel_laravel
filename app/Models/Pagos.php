<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $fillable = [
        'estancia_id',
        'monto',
        'metodo_pago',
        'tipo',
        'estado',
        'referencia',
        'fecha_pago',
        'observaciones',
        'user_id',
    ];

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
