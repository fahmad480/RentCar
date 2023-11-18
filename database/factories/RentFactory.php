<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'car_id' => $this->faker->numberBetween(1, 10),
            'date_start' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'date_end' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'date_return' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'total_price' => $this->faker->numberBetween(100000, 1000000),
            'status' => $this->faker->randomElement(['in rental', 'returned']),
        ];
    }
}
