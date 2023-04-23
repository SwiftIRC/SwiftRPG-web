<?php

namespace Database\Factories;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Command>
 */
class CommandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'class' => 'thieving',
            'method' => 'pickpocket',
            'verb' => 'pickpocketing',
            'emoji' => '🕵️',
            'ticks' => 1,
            'reward_id' => Reward::factory()->create()->id,
            'log' => true,
        ];
    }

}
