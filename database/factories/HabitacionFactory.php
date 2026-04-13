<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Habitacion>
 */
class HabitacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero' => fake()->unique()->numberBetween(100, 500),
            'id_tipo' => TipoHabitacion::inRandomOrder()->first()->id_tipo,
            'piso' => fake()->numberBetween(1, 5),
            'estado' => 'disponible'
        ];
    }
}
