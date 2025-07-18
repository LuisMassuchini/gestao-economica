<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EconomicGroup; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flag>
 */
class FlagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->word(), // Gera uma palavra falsa
            // Associa a um Grupo Económico. Se não existir, cria um novo.
            'economic_group_id' => EconomicGroup::factory(),
        ];
    }
}
