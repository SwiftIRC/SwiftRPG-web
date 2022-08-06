<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => false,
            'is_accessible' => false,
            'is_locked' => false,
            'is_bed' => false,
            'is_pilferable' => false,
        ];
    }
}
