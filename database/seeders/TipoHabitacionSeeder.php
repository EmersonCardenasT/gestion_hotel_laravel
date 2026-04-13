<?php

namespace Database\Seeders;

use App\Models\TipoHabitacion;
use Illuminate\Database\Seeder;

class TipoHabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoHabitacion::insert([
            [
                'nombre' => 'Simple',
                'descripcion' => 'Habitación simple 1 cama',
                'capacidad' => 1,
                'precio_base' => 80
            ],
            [
                'nombre' => 'Doble',
                'descripcion' => '2 camas individuales',
                'capacidad' => 2,
                'precio_base' => 120
            ],
            [
                'nombre' => 'Matrimonial',
                'descripcion' => '1 cama matrimonial',
                'capacidad' => 2,
                'precio_base' => 140
            ],
            [
                'nombre' => 'Suite',
                'descripcion' => 'Suite familiar',
                'capacidad' => 4,
                'precio_base' => 250
            ],
            [
                'nombre' => 'asd',
                'descripcion' => 'asd familiar',
                'capacidad' => 5,
                'precio_base' => 250
            ]
        ]);
    }
}
