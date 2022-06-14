<?php

namespace Database\Seeders;

use App\Models\Tile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tile::create([
            'name' => 'Grass',
            'description' => 'A grassy tile.',
            'terrain_id' => 1,
            'psuedo_id' => '1-1',
            'x' => 1,
            'y' => 1,
            'max_trees' => 0,
            'available_trees' => 0,
            'north_edge' => 1,
            'east_edge' => 1,
            'south_edge' => 1,
            'west_edge' => 1,
        ]);
    }
}
