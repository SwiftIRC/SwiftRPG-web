<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tile>
 */
class TileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'x' => $this->faker->randomDigit(1, 100),
            'y' => $this->faker->randomDigit(1, 100),
            'trees' => $this->faker->randomDigit(1, 100),
            'last_disturbed' => $this->faker->dateTime(),
        ];
    }
}
