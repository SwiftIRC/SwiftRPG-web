<?php

namespace Database\Seeders;

use App\Models\Command;
use App\Models\Item;
use App\Models\Reward;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class CommandSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $reward = Reward::create();

        $thieving = Skill::firstWhere('name', 'thieving');
        $pickpocket = Reward::create();
        $pickpocket->skills()->attach($thieving->id, ['value' => 5]);

        Command::create([
            'class' => 'thieving',
            'method' => 'pickpocket',
            'verb' => 'pickpocketing',
            'ticks' => 1,
            'reward_id' => $pickpocket->id,
        ]);

        $woodcutting = Skill::firstWhere('name', 'woodcutting');
        $chop = Reward::create();
        $chop->skills()->attach($woodcutting->id, ['value' => 5]);
        $logs = Item::firstWhere('name', 'Logs');
        $chop->items()->attach($logs->id, ['value' => 5]);

        Command::create([
            'class' => 'woodcutting',
            'method' => 'chop',
            'verb' => 'chopping wood',
            'ticks' => 1,
            'reward_id' => $chop->id,
        ]);

        $firemaking = Skill::firstWhere('name', 'firemaking');
        $burn = Reward::create();
        $burn->skills()->attach($firemaking->id, ['value' => 5]);
        $burn->items()->attach($logs->id, ['value' => -1]);

        Command::create([
            'class' => 'firemaking',
            'method' => 'burn',
            'verb' => 'burning logs',
            'ticks' => 1,
            'reward_id' => $burn->id,
        ]);

        Command::create([
            'class' => 'agility',
            'method' => 'look',
            'verb' => 'looking',
            'ticks' => 0,
            'log' => false,
        ]);

        Command::create([
            'class' => 'agility',
            'method' => 'npcs',
            'verb' => 'looking at people',
            'ticks' => 0,
            'log' => false,
        ]);

        Command::create([
            'class' => 'agility',
            'method' => 'buildings',
            'verb' => 'looking at buildings',
            'ticks' => 0,
            'log' => false,
        ]);

        $agility = Skill::firstWhere('name', 'agility');
        $explore = Reward::create();
        $explore->skills()->attach($agility->id, ['value' => 5]);

        Command::create([
            'class' => 'agility',
            'method' => 'explore',
            'verb' => 'exploring',
            'ticks' => 5,
            'reward_id' => $explore->id,
        ]);

        Command::create([
            'class' => 'questing',
            'method' => 'start',
            'verb' => 'questing',
            'ticks' => 0,
        ]);

        Command::create([
            'class' => 'questing',
            'method' => 'inspect',
            'verb' => 'questing',
            'ticks' => 0,
        ]);
    }
}
