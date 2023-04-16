<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Quest;
use App\Models\QuestStep;
use App\Models\QuestStepDependency;
use App\Models\Reward;
use App\Models\Skill;
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
        $this->seed_quest_two();
    }

    public function seed_quest_one()
    {
        $woodcutting = Skill::firstWhere('name', 'woodcutting');
        $quest1 = Reward::create();
        $quest1->skills()->attach($woodcutting->id, ['value' => 50]);
        $logs = Item::firstWhere('name', 'Logs');
        $quest1->items()->attach($logs->id, ['value' => 10]);
        $apple = Item::firstWhere('name', 'Apple');
        $quest1->items()->attach($apple->id, ['value' => 1]);

        Quest::create([
            'name' => 'Teacher\'s Pet',
            'description' => 'Use `.quest start 1` to start this quest.',
            'reward_id' => $quest1->id,
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

    }

    public function seed_quest_two()
    {
        $quest2 = Reward::create();
        $fishing = Skill::firstWhere('name', 'fishing');
        $quest2->skills()->attach($fishing->id, ['value' => 50]);

        Quest::create([
            'name' => 'Reeling in the Basics',
            'description' => 'Embark on a fishing adventure, starting from the basics and working your way up to become a master fisherman, facing challenges and earning rewards along the way.',
            'reward_id' => $quest2->id,
        ]);

        $step1 = QuestStep::create([
            'quest_id' => 2,
            'output' => 'You spot an old fisherman by the riverside and approach him to learn the art of fishing, starting with the basics of casting and baiting your hook.',
            'ticks' => 10,
        ]);

        $step2 = QuestStep::create([
            'quest_id' => 2,
            'output' => 'You have learned the basics of casting and baiting your hook. You are now ready to catch your first fish.',
            'ticks' => 10,
        ]);

        QuestStepDependency::create([
            'quest_id' => 2,
            'quest_step_id' => $step2->id,
            'quest_step_dependency_id' => $step1->id,
        ]);

        $step3 = QuestStep::create([
            'quest_id' => 2,
            'output' => 'You have caught your first fish! You are now ready to learn how to cook your catch.',
            'ticks' => 10,
        ]);

        QuestStepDependency::create([
            'quest_id' => 2,
            'quest_step_id' => $step3->id,
            'quest_step_dependency_id' => $step2->id,
        ]);

        $step4 = QuestStep::create([
            'quest_id' => 2,
            'output' => 'You have learned how to cook your catch. You are now ready to learn how to fish in the deep sea.',
            'ticks' => 5,
        ]);

        QuestStepDependency::create([
            'quest_id' => 2,
            'quest_step_id' => $step4->id,
            'quest_step_dependency_id' => $step3->id,
        ]);

        // QuestItemReward::create([
        //     'quest_id' => 2,
        //     'item_id' => 3, // TODO revisit this
        //     'quantity' => 50, // && this
        // ]);

    }
}
