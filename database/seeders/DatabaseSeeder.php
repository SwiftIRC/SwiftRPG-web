<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UserSeeder;
use Database\Seeders\ItemSeeder;

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
            TerrainSeeder::class,
            EdgeSeeder::class,
            TileSeeder::class,
            NpcSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
        ]);
    }
}
