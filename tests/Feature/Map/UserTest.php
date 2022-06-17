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

    public function test_user_location_lookup()
    {
        $tile = Tile::all()->first();

        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $response = $this->actingAs($user)->get(implode(['/api/map/user/', $user->name]));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $tile->id,
            'x' => $tile->x,
            'y' => $tile->y,
        ]);
    }

    public function test_user_can_move()
    {
        $tile = Tile::all()->first();

        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $tile2 = Tile::factory()->create([
            'discovered_by' => $user->id,
            'x' => $tile->x,
            'y' => $tile->y + 1,
            'psuedo_id' => implode([$tile->x, ',', $tile->y + 1]),
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
            'tile_id' => $tile2->id,
        ]);

        $this->assertDatabaseHas('tiles', [
            'id' => $tile2->id,
            'x' => $tile->x,
            'y' => $tile->y + 1,
        ]);
    }

    public function test_user_cannot_move()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id
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
            'tile_id' => $tile->id,
        ]);
    }

    public function test_user_can_look()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);
        $terrain = Terrain::factory()->create();

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
            'id' => $tile->id,
        ]);
    }
}
