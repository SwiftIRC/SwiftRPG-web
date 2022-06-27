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
        $grass = Terrain::where('id', 1)->first();
        $dirt = Terrain::where('id', 2)->first();
        $sand = Terrain::where('id', 3)->first();
        $water = Terrain::where('id', 4)->first();

        Edge::create([
            'name' => 'Grass',
            'description' => 'A grassy area. It feels comfortable here.',
            'terrain_id' => $grass->id,
        ]);

        Edge::create([
            'name' => 'Dirt',
            'description' => 'A dusty, dirty patch of land.',
            'terrain_id' => $dirt->id,
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
    }
}
