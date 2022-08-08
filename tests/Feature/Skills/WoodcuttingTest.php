<?php

namespace Tests\Feature\Skills;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WoodcuttingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_can_chop()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);


        $item = Item::factory()->create([
            'name' => 'Logs',
        ]);

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'woodcutting.chop',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'woodcutting' => 5,
        ]);

        $this->assertDatabaseHas('item_user', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_cannot_chop()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);
        $item = Item::factory()->create([
            'name' => 'Logs',
        ]);

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(403);
    }
}
