<?php

namespace Tests;

use App\Models\Edge;
use App\Models\Tile;
use App\Models\Terrain;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Terrain::factory()->create();
        $terrain = Terrain::all()->first();
        $edges = [
            Edge::create([
                'name' => 'north',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'east',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'south',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'west',
                'terrain_id' => $terrain->id,
            ]),
        ];
        $tile = Tile::factory()->create([
            'terrain_id' => $terrain->id,
        ]);
        foreach ($edges as $edge) {
            $tile->edges()->attach($edge, ['is_road' => true, 'direction' => $edge->name]);
        }
    }
}
