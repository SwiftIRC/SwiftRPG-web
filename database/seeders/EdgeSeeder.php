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

        $edge = Edge::where('id', '1')->first();

        // $edge->terrains()->attach($grassy);

        // $tile->edges()->attach($edge, ['direction' => 'north', 'is_road' => true]);
        // $tile->edges()->attach($edge, ['direction' => 'east', 'is_road' => true]);
        // $tile->edges()->attach($edge, ['direction' => 'south', 'is_road' => true]);
        // $tile->edges()->attach($edge, ['direction' => 'west', 'is_road' => true]);

        Edge::create([
            'name' => 'Dirt',
            'description' => 'A dusty, dirty patch of land.',
        ]);

        Edge::create([
            'name' => 'Sandy',
            'description' => 'A dry, sandy area.',
        ]);

        Edge::create([
            'name' => 'Water',
            'Description' => 'A watery area.',
        ]);
    }
}
