<?php

namespace Tests\Feature\Map;

use App\Models\Npc;
use Tests\TestCase;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;
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
        $user = User::factory()->create();
        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
        ]);
        $edges = [
            Edge::factory()->create(),
            Edge::factory()->create(),
            Edge::factory()->create(),
            Edge::factory()->create(),
        ];
        foreach ($edges as $edge) {
            $tile->edges()->attach($edge);
        }

        $response = $this->actingAs($user)->get(implode(['/api/map/tile/', $tile->x, '/', $tile->y, '/edges']));

        $response->assertStatus(200);
        $response->assertJson([
            [
                'id' => 1,
                'name' => $edges[0]->name,
                'description' => $edges[0]->description,
            ],
            [
                'id' => 2,
                'name' => $edges[1]->name,
                'description' => $edges[1]->description,
            ],
            [
                'id' => 3,
                'name' => $edges[2]->name,
                'description' => $edges[2]->description,
            ],
            [
                'id' => 4,
                'name' => $edges[3]->name,
                'description' => $edges[3]->description,
            ]
        ]);
    }
}
