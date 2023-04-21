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
            SkillSeeder::class,
            NameSeeder::class,
            ItemSeeder::class,
            CommandSeeder::class,
            TerrainSeeder::class,
            EdgeSeeder::class,
            TileSeeder::class,
            NpcSeeder::class,
            UserSeeder::class,
            QuestSeeder::class,
        ]);
    }
}
