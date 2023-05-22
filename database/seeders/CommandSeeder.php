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
        $thieving = Skill::firstWhere('name', 'thieving');
        $pickpocket = Reward::create();
        $pickpocket->skills()->attach($thieving->id, ['quantity' => 5]);
        $gold = Item::firstWhere('name', 'Gold');
        $pickpocket->items()->attach($gold->id, ['quantity' => 5]);

        Command::factory()->create([
            'class' => 'thieving',
            'method' => 'pickpocket',
            'verb' => 'pickpocketing',
            'emoji' => '🕵️',
            'ticks' => 1,
            'reward_id' => $pickpocket->id,
        ]);

        $woodcutting = Skill::firstWhere('name', 'woodcutting');
        $chop = Reward::create();
        $chop->skills()->attach($woodcutting->id, ['quantity' => 5]);
        $logs = Item::firstWhere('name', 'Logs');
        $chop->items()->attach($logs->id, ['quantity' => 5]);

        Command::factory()->create([
            'class' => 'woodcutting',
            'method' => 'chop',
            'verb' => 'chopping wood',
            'emoji' => '🪓',
            'ticks' => 1,
            'reward_id' => $chop->id,
        ]);

        $firemaking = Skill::firstWhere('name', 'firemaking');
        $burn = Reward::create();
        $burn->skills()->attach($firemaking->id, ['quantity' => 5]);
        $burn->items()->attach($logs->id, ['quantity' => -1]);

        Command::factory()->create([
            'class' => 'firemaking',
            'method' => 'burn',
            'verb' => 'burning logs',
            'emoji' => '🔥',
            'ticks' => 1,
            'reward_id' => $burn->id,
        ]);

        Command::factory()->create([
            'class' => 'agility',
            'method' => 'look',
            'verb' => 'looking',
            'emoji' => '👀',
            'ticks' => 0,
            'log' => false,
        ]);

        Command::factory()->create([
            'class' => 'agility',
            'method' => 'npcs',
            'verb' => 'looking at people',
            'emoji' => '👀',
            'ticks' => 0,
            'log' => false,
        ]);

        Command::factory()->create([
            'class' => 'agility',
            'method' => 'buildings',
            'verb' => 'looking at buildings',
            'emoji' => '👀',
            'ticks' => 0,
            'log' => false,
        ]);

        $agility = Skill::firstWhere('name', 'agility');
        $explore = Reward::create();
        $explore->skills()->attach($agility->id, ['quantity' => 5]);

        Command::factory()->create([
            'class' => 'agility',
            'method' => 'explore',
            'verb' => 'exploring',
            'emoji' => '🏃',
            'ticks' => 5,
            'reward_id' => $explore->id,
        ]);

        Command::factory()->create([
            'class' => 'questing',
            'method' => 'start',
            'verb' => 'questing',
            'emoji' => '📜',
            'ticks' => 0,
        ]);

        Command::factory()->create([
            'class' => 'questing',
            'method' => 'inspect',
            'verb' => 'questing',
            'emoji' => '📜',
            'ticks' => 0,
        ]);

        Command::factory()->create([
            'class' => 'eventing',
            'method' => 'engage',
            'verb' => 'engaging a special event',
            'emoji' => '🌟',
            'ticks' => 1,
        ]);

        $fishing = Skill::firstWhere('name', 'fishing');
        $raw_fish = Item::where('name', 'Raw Fish')->first();
        $fish_cmd = Reward::create();
        $fish_cmd->skills()->attach($fishing->id, ['quantity' => 5]);
        $fish_cmd->items()->attach($raw_fish->id, ['quantity' => 1]);

        Command::factory()->create([
            'class' => 'fishing',
            'method' => 'fish',
            'verb' => 'fishing',
            'emoji' => '🎣',
            'ticks' => 1,
            'reward_id' => $fish_cmd->id,
        ]);

        $cooking = Skill::firstWhere('name', 'cooking');
        $fish = Item::where('name', 'Fish')->first();
        $cook_cmd = Reward::create();
        $cook_cmd->skills()->attach($cooking->id, ['quantity' => 5]);
        $cook_cmd->items()->attach($raw_fish->id, ['quantity' => -1]);
        $cook_cmd->items()->attach($fish->id, ['quantity' => 1]);

        Command::factory()->create([
            'class' => 'cooking',
            'method' => 'cook',
            'verb' => 'cooking',
            'emoji' => '🍳',
            'ticks' => 1,
            'reward_id' => $cook_cmd->id,
        ]);

        $mining = Skill::firstWhere('name', 'mining');
        $ore = Item::where('name', 'Iron Ore')->first();
        $mine_cmd = Reward::create();
        $mine_cmd->skills()->attach($mining->id, ['quantity' => 5]);
        $mine_cmd->items()->attach($ore->id, ['quantity' => 1]);

        Command::factory()->create([
            'class' => 'mining',
            'method' => 'mine',
            'verb' => 'mining',
            'emoji' => '⛏️',
            'ticks' => 1,
            'reward_id' => $mine_cmd->id,
        ]);

        $smithing = Skill::firstWhere('name', 'smithing');
        $bar = Item::where('name', 'Iron Bar')->first();
        $smelt_cmd = Reward::create();
        $smelt_cmd->skills()->attach($smithing->id, ['quantity' => 5]);
        $smelt_cmd->items()->attach($ore->id, ['quantity' => -1]);
        $smelt_cmd->items()->attach($bar->id, ['quantity' => 1]);

        Command::factory()->create([
            'class' => 'smithing',
            'method' => 'smelt',
            'verb' => 'smelting',
            'emoji' => '🏭',
            'ticks' => 1,
            'reward_id' => $smelt_cmd->id,
        ]);

        $smith_cmd = Reward::create();
        $smith_cmd->skills()->attach($smithing->id, ['quantity' => 5]);
        $smith_cmd->items()->attach($bar->id, ['quantity' => -1]);
        $sword = Item::where('name', 'Iron Sword')->first();
        $smith_cmd->items()->attach($sword->id, ['quantity' => 1]);

        Command::factory()->create([
            'class' => 'smithing',
            'method' => 'smith',
            'verb' => 'smithing',
            'emoji' => '🔨',
            'ticks' => 1,
            'reward_id' => $smith_cmd->id,
        ]);

        $reinforce = Reward::create();
        $reinforce->skills()->attach($smithing->id, ['quantity' => 5]);
        $reinforce->items()->attach($sword->id, ['quantity' => -2]);
        $durable_sword = Item::where('name', 'Durable Iron Sword')->first();
        $reinforce->items()->attach($durable_sword->id, ['quantity' => 1]);

        Command::factory()->create([
            'class' => 'smithing',
            'method' => 'reinforce',
            'verb' => 'reinforcing',
            'emoji' => '⚒️',
            'ticks' => 1,
            'reward_id' => $reinforce->id,
        ]);
    }
}
