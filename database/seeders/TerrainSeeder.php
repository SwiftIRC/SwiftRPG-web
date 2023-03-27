<?php

namespace Database\Seeders;

use App\Models\Terrain;
use Illuminate\Database\Seeder;

class TerrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Terrain::create([
            'name' => 'Grass',
            'description' => 'A grassy field.',
        ]);

        Terrain::create([
            'name' => 'Forest',
            'description' => 'A piece of land with many trees.',
            'movement_cost' => 1,
        ]);

        Terrain::create([
            'name' => 'Sand',
            'description' => 'A dry, sandy area.',
            'movement_cost' => 2,
        ]);

        Terrain::create([
            'name' => 'Water',
            'description' => 'A watery area.',
        ]);

        Terrain::create([
            'name' => 'Mountains',
            'description' => 'A mountainous area.',
            'movement_cost' => 3,
        ]);
    }
}
