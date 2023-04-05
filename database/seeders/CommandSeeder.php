<?php

namespace Database\Seeders;

use App\Models\Command;
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
        Command::create([
            'class' => 'thieving',
            'method' => 'pickpocket',
            'verb' => 'pickpocketing',
            'ticks' => 1,
        ]);

        Command::create([
            'class' => 'woodcutting',
            'method' => 'chop',
            'verb' => 'chopping wood',
            'ticks' => 1,
        ]);

        Command::create([
            'class' => 'firemaking',
            'method' => 'burn',
            'verb' => 'burning logs',
            'ticks' => 1,
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

        Command::create([
            'class' => 'agility',
            'method' => 'explore',
            'verb' => 'exploring',
            'ticks' => 5,
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
