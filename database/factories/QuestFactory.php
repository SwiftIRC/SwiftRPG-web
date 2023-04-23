<?php

namespace Database\Factories;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quest>
 */
class QuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reward_id = Reward::factory()->create()->id;
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'reward_id' => $reward_id,
        ];
    }
}
