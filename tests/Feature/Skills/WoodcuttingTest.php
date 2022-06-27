<?php

namespace Tests\Feature\Skills;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Tile;
use App\Models\User;
use App\Models\Inventory;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WoodcuttingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Inventory::flushEventListeners();
    }

    public function test_user_can_chop()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
            'size' => 5,
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

        $this->assertDatabaseHas('inventory_item', [
            'inventory_id' => $inventory->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_cannot_chop()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
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
