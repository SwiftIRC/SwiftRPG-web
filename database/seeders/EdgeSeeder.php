<?php

namespace Database\Seeders;

use App\Models\Edge;
use App\Models\Tile;
use App\Models\Terrain;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EdgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grassy = Terrain::where('id', 1)->first();
        $tile = Tile::where('psuedo_id', '0,0')->first();

        $edge = Edge::create([
            'name' => 'Grass',
            'description' => 'A grassy field.',
        ]);

        $edge->terrains()->attach($grassy);

        $tile->edges()->attach($edge, ['direction' => 'north', 'is_road' => true]);
        $tile->edges()->attach($edge, ['direction' => 'east', 'is_road' => true]);
        $tile->edges()->attach($edge, ['direction' => 'south', 'is_road' => true]);
        $tile->edges()->attach($edge, ['direction' => 'west', 'is_road' => true]);

        Edge::create([
            'name' => 'Grassy Field Road',
            'description' => 'A grassy field with a road in the middle.',
        ]);

        Edge::create([
            'name' => 'Dirt',
            'description' => 'A dusty, dirty patch of land.',
        ]);
    }
}
