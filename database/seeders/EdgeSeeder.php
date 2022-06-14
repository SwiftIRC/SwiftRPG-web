<?php

namespace Database\Seeders;

use App\Models\Edge;
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
        Edge::create([
            'name' => 'Grass',
            'description' => 'A grassy field.',
        ]);

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
