<?php

namespace Tests\Feature\Map;

use App\Models\Npc;
use Tests\TestCase;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;
use App\Models\Terrain;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EdgeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_edge_lookup()
    {
        $terrain = Terrain::all()->first();
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);
        $edge = Edge::factory()->create([
            'terrain_id' => $terrain->id,
        ]);
        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
            'terrain_id' => $terrain->id,
        ]);
        $directions = ['north', 'east', 'south', 'west'];
        for ($x = 0; $x < count($directions); $x++) {
            $tile->edges()->attach($edge, ['direction' => $directions[$x]]);
        }

        $response = $this->actingAs($user)->get(implode(['/api/map/tile/', $tile->x, '/', $tile->y, '/edges']));

        $response->assertStatus(200);
        $response->assertJson([
            [
                'id' => $edge->id,
                'name' => $edge->name,
                'description' => $edge->description,
                'pivot' => [
                    'direction' => 'north',
                ],
            ],
            [
                'id' => $edge->id,
                'name' => $edge->name,
                'description' => $edge->description,
                'pivot' => [
                    'direction' => 'east',
                ],
            ],
            [
                'id' => $edge->id,
                'name' => $edge->name,
                'description' => $edge->description,
                'pivot' => [
                    'direction' => 'south',
                ],
            ],
            [
                'id' => $edge->id,
                'name' => $edge->name,
                'description' => $edge->description,
                'pivot' => [
                    'direction' => 'west',
                ],
            ]
        ]);
    }
}