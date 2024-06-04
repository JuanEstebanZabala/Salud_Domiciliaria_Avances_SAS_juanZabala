<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\empleados>
 */
class EmpleadosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->mail(),
            'role' => fake()->string(['Developer','Designer','Product Manager']),
            'location' => fake()->city(),
            'typography' => fake()->randomLetter(),            
            'avatar' => fake()->string()           
        ];
    }
}
