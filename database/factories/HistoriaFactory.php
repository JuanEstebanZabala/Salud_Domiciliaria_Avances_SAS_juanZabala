<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historia>
 */
class HistoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_profesional' => fake()->number_format(),
            'informacion_relevante' => fake()->string(),
            'hora' => fake()->time(),
            'fecha' => fake()->date(),
            'consecutivo' => fake()->number_format(),            
            'estado' => fake()->string('pendiente'),
            'antecedentes' => fake()->string(),
            'evaluacion' => fake()->string(),
            'concepto'  => fake()->string(),
            'recomendaciones'=>fake()->string(),
            'id_paciente'=>fake()->number_format()
        ];
    }
}
