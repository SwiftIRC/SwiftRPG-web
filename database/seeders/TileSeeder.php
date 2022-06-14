<?php

namespace Database\Seeders;

use App\Models\Edge;
use App\Models\Tile;
use App\Models\Terrain;
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
        $terrain = Terrain::where('id', 1)->first();

        $tiles = [
            Tile::create([
                'psuedo_id' => '0,0',
                'x' => 0,
                'y' => 0,
                'max_trees' => 15,
                'available_trees' => 15,
            ]),
            Tile::create([
                'psuedo_id' => '1,0',
                'x' => 1,
                'y' => 0,
                'max_trees' => 0,
                'available_trees' => 0,
            ]),
            Tile::create([
                'psuedo_id' => '0,1',
                'x' => 0,
                'y' => 1,
                'max_trees' => 0,
                'available_trees' => 0,
            ]),
            Tile::create([
                'psuedo_id' => '0,-1',
                'x' => 0,
                'y' => -1,
                'max_trees' => 0,
                'available_trees' => 0,
            ]),
            Tile::create([
                'psuedo_id' => '-1,0',
                'x' => -1,
                'y' => 0,
                'max_trees' => 5,
                'available_trees' => 5,
            ]),
        ];

        $edge = Edge::where('id', '1')->first();
        $tiles[0]->edges()->attach($edge);
        $tiles[0]->terrains()->attach($terrain);
    }
}
