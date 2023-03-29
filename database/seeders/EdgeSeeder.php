<?php

namespace Database\Seeders;

use App\Models\Edge;
use App\Models\Terrain;
use Illuminate\Database\Seeder;

class EdgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grass = Terrain::where('id', 1)->first();
        $forest = Terrain::where('id', 2)->first();
        $sand = Terrain::where('id', 3)->first();
        $water = Terrain::where('id', 4)->first();
        $mountains = Terrain::where('id', 5)->first();

        Edge::create([
            'name' => 'Grass',
            'description' => 'A grassy area. It feels comfortable here.',
            'terrain_id' => $grass->id,
        ]);

        Edge::create([
            'name' => 'Forest',
            'description' => 'An area with a lot of trees available.',
            'terrain_id' => $forest->id,
        ]);

        Edge::create([
            'name' => 'Sand',
            'description' => 'A dry, sandy area.',
            'terrain_id' => $sand->id,
        ]);

        Edge::create([
            'name' => 'Water',
            'description' => 'A watery area.',
            'terrain_id' => $water->id,
        ]);

        Edge::create([
            'name' => 'Mountains',
            'description' => 'A mountainous area.',
            'terrain_id' => $mountains->id,
        ]);
    }
}
