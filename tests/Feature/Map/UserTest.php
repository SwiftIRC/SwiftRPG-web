<?php

namespace Tests\Feature\Map;

use App\Models\Npc;
use Tests\TestCase;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;
use App\Models\Building;
use App\Models\Terrain;
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

    public function test_user_can_move()
    {
        $user = User::factory()->create();

        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
            'x' => $user->x,
            'y' => $user->y,
            'psuedo_id' => implode([$user->x, ',', $user->y]),
        ]);

        $edges = [
            Edge::create([
                'name' => 'north',
                'direction' => 'north',
            ]),
            Edge::create([
                'name' => 'east',
                'direction' => 'east',
            ]),
            Edge::create([
                'name' => 'south',
                'direction' => 'south',
            ]),
            Edge::create([
                'name' => 'west',
                'direction' => 'west',
            ]),
        ];

        foreach ($edges as $edge) {
            $tile->edges()->attach($edge, ['is_road' => true]);
        }

        $response = $this->actingAs($user)->post('/api/map/user/move', [
            'direction' => 'north',
        ]);

        $response->assertJson([
            'x' => $tile->x,
            'y' => $tile->y + 1,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'x' => $tile->x,
            'y' => $tile->y + 1,
        ]);
    }

    public function test_user_cannot_move()
    {
        $user = User::factory()->create();

        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
            'x' => $user->x,
            'y' => $user->y,
            'psuedo_id' => implode([$user->x, ',', $user->y]),
        ]);

        $edges = [
            Edge::create([
                'name' => 'north',
                'direction' => 'north',
            ]),
            Edge::create([
                'name' => 'east',
                'direction' => 'east',
            ]),
            Edge::create([
                'name' => 'south',
                'direction' => 'south',
            ]),
            Edge::create([
                'name' => 'west',
                'direction' => 'west',
            ]),
        ];

        foreach ($edges as $edge) {
            $tile->edges()->attach($edge, ['is_road' => false]);
        }

        $response = $this->actingAs($user)->post('/api/map/user/move', [
            'direction' => 'north',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'x' => $tile->x,
            'y' => $tile->y,
        ]);
    }

    public function test_user_can_look()
    {
        $user = User::factory()->create();
        $terrain = Terrain::factory()->create();

        $tile = Tile::factory()->create([
            'discovered_by' => $user->id,
            'x' => $user->x,
            'y' => $user->y,
            'psuedo_id' => implode([$user->x, ',', $user->y]),
        ]);

        $tile->terrains()->attach($terrain);

        $edges = [
            Edge::create([
                'name' => 'north',
                'direction' => 'north',
            ])->terrains()->attach($terrain),
            Edge::create([
                'name' => 'east',
                'direction' => 'east',
            ]),
            Edge::create([
                'name' => 'south',
                'direction' => 'south',
            ]),
            Edge::create([
                'name' => 'west',
                'direction' => 'west',
            ]),
        ];

        foreach ($edges as $edge) {
            $tile->edges()->attach($edge, ['is_road' => false]);
        }

        $npcs = Npc::factory()->count(3);
        foreach ($npcs as $npc) {
            $tile->npcs()->attach($npc);
        }



        $response = $this->actingAs($user)->get('/api/map/user/look');

        $response->assertStatus(200);

        $response->assertJson([
            'discovered_by' => $user->id,
        ]);
    }
}
