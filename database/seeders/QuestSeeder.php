<?php

namespace Database\Seeders;

use App\Models\Quest;
use App\Models\QuestItemReward;
use App\Models\QuestStep;
use App\Models\QuestStepDependency;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed_quest_one();

    }

    public function seed_quest_one()
    {
        Quest::create([
            'name' => 'Teacher\'s Pet',
            'description' => 'Use `.quest start 1` to start this quest.',
            'woodcutting' => 50,
        ]);

        QuestStep::create([
            'quest_id' => 1,
            'output' => 'Your teacher has asked you to collect 10 logs. Use `.quest start 1 2` to proceed (in two (2) ticks).',
            'ticks' => 2,
        ]);

        $step = QuestStep::create([
            'quest_id' => 1,
            'output' => 'Your teacher has asked you to collect 1 apple. Use `.quest inspect 1` to view progress.',
            'ticks' => 5,
        ]);

        QuestStepDependency::create([
            'quest_id' => 1,
            'quest_step_id' => $step->id,
            'quest_step_dependency_id' => 1,
        ]);

        $step = QuestStep::create([
            'quest_id' => 1,
            'output' => 'You report your progress back to the teacher and... Congratulations! You have completed the first quest. In one (1) tick you will receive your reward.',
            'ticks' => 1,
        ]);

        QuestStepDependency::create([
            'quest_id' => 1,
            'quest_step_id' => $step->id,
            'quest_step_dependency_id' => 2,
        ]);

        QuestItemReward::create([
            'quest_id' => 1,
            'item_id' => 1,
            'quantity' => 10,
        ]);

        QuestItemReward::create([
            'quest_id' => 1,
            'item_id' => 2,
            'quantity' => 1,
        ]);
    }
}
