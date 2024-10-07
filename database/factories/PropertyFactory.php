<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 100000, 10000000),
            'size' => $this->faker->randomFloat(2, 500, 5000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'property_type' => $this->faker->randomElement([1, 2, 3, 4, 5, 6]),
            'status' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'condition' => $this->faker->randomElement([1, 2, 3]),
            'owner_id' => null,
            'location_id' => null,
            'date_built' => $this->faker->date(),
            'parking_spaces' => $this->faker->numberBetween(0, 5),
            'utilities_included' => $this->faker->boolean(),
            'lease_terms' => $this->faker->randomElement([12, 24, 36, 48, 60, 72]),
        ];
    }
}
