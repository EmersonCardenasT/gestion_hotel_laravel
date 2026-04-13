<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use Illuminate\Database\Seeder;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Habitacion::insert([

            ['numero' => '101', 'id_tipo' => 1, 'piso' => 1],
            ['numero' => '102', 'id_tipo' => 1, 'piso' => 1],
            ['numero' => '103', 'id_tipo' => 2, 'piso' => 1],
            ['numero' => '104', 'id_tipo' => 3, 'piso' => 1],

            ['numero' => '201', 'id_tipo' => 2, 'piso' => 2],
            ['numero' => '202', 'id_tipo' => 3, 'piso' => 2],
            ['numero' => '203', 'id_tipo' => 4, 'piso' => 2],
            ['numero' => '204', 'id_tipo' => 4, 'piso' => 2]

        ]);
    }
}
