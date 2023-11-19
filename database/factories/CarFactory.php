<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'type' => $this->faker->word,
            'license_plate' => $this->faker->word,
            'color' => $this->faker->word,
            'year' => $this->faker->year($max = 'now'),
            'machine_number' => $this->faker->word,
            'chasis_number' => $this->faker->word,
            'image' => $this->faker->word,
            'seat' => $this->faker->word,
            'price' => $this->faker->word,
            'status' => $this->faker->word,
        ];
    }
}
