<?php

namespace Tests\Feature\Map;

use App\Models\Npc;
use Tests\TestCase;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_location_lookup()
    {
        $user = User::factory()->create();

        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
            'x' => $user->x,
            'y' => $user->y,
            'psuedo_id' => implode([$user->x, ',', $user->y]),
        ]);

        $response = $this->actingAs($user)->get(implode(['/api/map/user/', $user->name]));

        $response->assertStatus(200);
        $response->assertJson([
            'x' => $tile->x,
            'y' => $tile->y,
        ]);
    }
}
