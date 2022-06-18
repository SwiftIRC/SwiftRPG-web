<?php

namespace Database\Seeders;

use App\Models\Terrain;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'name' => 'Grassy',
            'description' => 'A grassy field.',
        ]);

        Terrain::create([
            'name' => 'Water',
            'description' => 'A watery area.',
        ]);
    }
}
