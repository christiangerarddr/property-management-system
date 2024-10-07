<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class PropertyImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'block_number' => $this->faker->numberBetween(1, 100),
            'lot_number' => $this->faker->numberBetween(1, 100),
            'street' => $this->faker->streetAddress,
            'village' => $this->faker->streetName,
            'city' => $this->faker->city,
            'region' => $this->faker->state,
        ];
    }
}
