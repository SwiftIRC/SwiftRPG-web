<?php

namespace Tests\Feature\Skills;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Tile;
use App\Models\User;
use App\Models\Inventory;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FiremakingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Inventory::flushEventListeners();
    }

    public function test_user_can_burn()
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

        $inventory->items()->attach($item);

        $response = $this->actingAs($user)->post('/api/firemaking/burn', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'firemaking.burn',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firemaking' => 5,
        ]);

        $this->assertDatabaseHas('inventory_item', [
            'inventory_id' => $inventory->id,
            'item_id' => $item->id,
            'deleted_at' => $item->deleted_at,
        ]);
    }

    public function test_user_cannot_burn()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        Item::factory()->create([
            'name' => 'Logs',
        ]);

        $response = $this->actingAs($user)->post('/api/firemaking/burn', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(500);
    }
}
