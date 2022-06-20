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

class TileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_tile_lookup()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);

        $terrain = Terrain::all()->first();

        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
            'terrain_id' => $terrain->id,
        ]);

        $response = $this->actingAs($user)->get(implode(['/api/map/tile/', $tile->x, '/', $tile->y]));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $tile->id,
            'discovered_by' => $user->id,
            'psuedo_id' => implode([$tile->x, ',', $tile->y]),
            'x' => $tile->x,
            'y' => $tile->y,
            'max_trees' => $tile->max_trees,
            'available_trees' => $tile->available_trees,
            'last_disturbed' => $tile->last_disturbed->format('Y-m-d H:i:s'),
        ]);
    }
}