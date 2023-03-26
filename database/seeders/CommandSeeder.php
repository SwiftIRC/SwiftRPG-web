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

    }
}
