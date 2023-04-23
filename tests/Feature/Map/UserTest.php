<?php

namespace Tests\Feature\Map;

use App\Models\Command;
use App\Models\Edge;
use App\Models\Terrain;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_location_lookup()
    {
        $tile = Tile::all()->first();

        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $command = Command::create([
            'class' => 'agility',
            'method' => 'look',
            'verb' => 'looking',
            'ticks' => 0,
            'log' => false,
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

        $user = User::factory()->create();

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

        $command = Command::where('class', 'agility')->where('method', 'explore')->first();

        $response = $this->actingAs($user)->post('/api/map/user/explore', [
            'direction' => 'north',
        ], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertJson([
            'ticks' => $terrain->movement_cost + $command->ticks,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'tile_id' => $tile->id,
        ]);

        $this->artisan('tick:process --ticks=10');

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

        $tile = Tile::firstWhere('psuedo_id', '0,0');

        $tile2 = Tile::create([
            'x' => $tile->x,
            'y' => $tile->y + 1,
            'psuedo_id' => implode([$tile->x, ',', $tile->y + 1]),
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
            'tile_id' => $tile2->id,
        ]);

        $command = Command::where('class', 'agility')->where('method', 'explore')->first();

        $response = $this->actingAs($user)->post(
            '/api/map/user/explore',
            [
                'direction' => 'north',
            ],
            [
                'X-Client-Id' => 'this-is-a-test',
                'X-Bot-Token' => config('app.token'),
            ]
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'tile_id' => $tile2->id,
        ]);

        $response->assertJson([
            'metadata' => [],
            'failure' => 'There is no road in that direction.',
        ]);

    }

    public function test_user_can_look()
    {
        $user = User::factory()->create();

        $command = Command::where('class', 'agility')->where('method', 'look')->first();

        $response = $this->actingAs($user)->get('/api/map/user/look', ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertJson([
            'command' => [
                'method' => $command->method,
                'verb' => $command->verb,
            ],
            'failure' => null,
        ]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'reward' => [
                'experience',
                'loot',
            ],
            'metadata' => [
                'buildings',
                'npcs',
            ],
        ]);
    }
}
