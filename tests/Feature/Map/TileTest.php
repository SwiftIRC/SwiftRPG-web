<?php

namespace Tests\Feature\Map;

use Tests\TestCase;
use App\Models\Tile;
use App\Models\User;
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
        $user = User::factory()->create();
        $tile = Tile::factory()->create();

        $response = $this->get('/api/map/tile/' . $tile->x . '/' . $tile->y);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $tile->id,
            'x' => $tile->x,
            'y' => $tile->y,
            'trees' => $tile->trees,
            'last_disturbed' => $tile->last_disturbed,
        ]);
    }
}
