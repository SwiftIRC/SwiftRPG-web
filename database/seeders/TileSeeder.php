<?php

namespace Database\Seeders;

use App\Models\Edge;
use App\Models\Terrain;
use App\Models\Tile;
use Illuminate\Database\Seeder;

class TileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terrain = Terrain::all()->first(); # Grass

        $tiles = [
            Tile::create([
                'psuedo_id' => '0,0',
                'x' => 0,
                'y' => 0,
                'max_trees' => 15,
                'available_trees' => 15,
                'terrain_id' => $terrain->id,
            ]),
        ];

        $edge = Edge::where('name', 'Grass')->first();

        foreach ($tiles as $tile) {
            $tile->edges()->attach($edge, ['direction' => 'north', 'is_road' => true]);
            $tile->edges()->attach($edge, ['direction' => 'east', 'is_road' => true]);
            $tile->edges()->attach($edge, ['direction' => 'south', 'is_road' => true]);
            $tile->edges()->attach($edge, ['direction' => 'west', 'is_road' => true]);
        }
    }
}
