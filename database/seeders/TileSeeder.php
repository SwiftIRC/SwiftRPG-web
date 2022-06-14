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

        $tile = Tile::create([
            'psuedo_id' => '0-0',
            'x' => 0,
            'y' => 0,
            'max_trees' => 0,
            'available_trees' => 0,
        ]);

        $edge = Edge::where('id', '1')->first();
        $tile->edges()->attach($edge);
        $tile->terrains()->attach($terrain);
    }
}
