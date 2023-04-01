<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            NameSeeder::class,
            CommandSeeder::class,
            TerrainSeeder::class,
            EdgeSeeder::class,
            TileSeeder::class,
            NpcSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            QuestSeeder::class,
        ]);
    }
}
