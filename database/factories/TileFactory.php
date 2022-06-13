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
        $x = $this->faker->randomDigit(1, 100);
        $y = $this->faker->randomDigit(1, 100);
        return [
            'psuedo_id' => $x . '-' . $y,
            'x' => $x,
            'y' => $y,

            'trees' => $this->faker->randomDigit(0, 100),

            'north_edge' => $this->faker->randomDigit(0, 100),
            'east_edge' => $this->faker->randomDigit(0, 100),
            'south_edge' => $this->faker->randomDigit(0, 100),
            'west_edge' => $this->faker->randomDigit(0, 100),

            'last_disturbed' => $this->faker->dateTime(),
        ];
    }
}
