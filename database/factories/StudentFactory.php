<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // RA: string 13 caracteres, pode ser algo como número randomizado
            'ra' => $this->faker->unique()->numerify('#############'), // 13 dígitos

            // Cria ou usa um User existente (relacionado)
            'user_id' => User::factory(),

            // Semestre entre 1 e 10 (restrição na migration)
            'semester' => $this->faker->numberBetween(1, 10),

            // group_id inicialmente nulo (grupo pode ser atribuído depois)
            'group_id' => null,
        ];
    }
}
