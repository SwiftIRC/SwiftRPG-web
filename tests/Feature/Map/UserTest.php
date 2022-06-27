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
        $terrain = Terrain::all()->first();
        $tile = Tile::all()->first();

        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $tile2 = Tile::create([
            'discovered_by' => $user->id,
            'x' => $tile->x,
            'y' => $tile->y + 1,
            'psuedo_id' => implode([$tile->x, ',', $tile->y + 1]),
            'terrain_id' => $terrain->id,
        ]);

        $edges = [
            Edge::create([
                'name' => 'north',
                'direction' => 'north',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'east',
                'direction' => 'east',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'south',
                'direction' => 'south',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'west',
                'direction' => 'west',
                'terrain_id' => $terrain->id,
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
        $terrain = Terrain::all()->first();

        $tile = Tile::all()->first();

        $tile2 = Tile::create([
            'x' => $tile->x,
            'y' => $tile->y + 1,
            'psuedo_id' => implode([1, ',', 1]),
            'terrain_id' => $terrain->id,
        ]);

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

        foreach ($edges as $edge) {
            $tile->edges()->attach($edge, ['is_road' => false, 'direction' => $edge->name]);
        }

        $user = User::factory()->create([
            'tile_id' => $tile2->id
        ]);

        $response = $this->actingAs($user)->post('/api/map/user/move', [
            'direction' => 'north',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'tile_id' => $tile2->id,
        ]);
    }

    public function test_user_can_look()
    {
        $terrain = Terrain::all()->first();
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

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
