<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestStepDependency>
 */
class QuestStepDependencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'quest_id' => 1,
            'quest_step_id' => 1,
            'quest_step_dependency_id' => 1,
        ];
    }
}
