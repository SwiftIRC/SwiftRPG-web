<?php

namespace Tests\Feature\Skills;

use App\Models\Command;
use App\Models\Item;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FiremakingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_can_burn_one_log()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $item = Item::factory()->create([
            'name' => 'Logs',
        ]);

        $user->items()->attach($item);
        $user->items()->attach($item);

        $command = Command::create([
            'class' => 'firemaking',
            'method' => 'burn',
            'verb' => 'burning',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/firemaking/burn', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firemaking' => 0,
        ]);

        $this->artisan('tick:process');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firemaking' => 5,
        ]);

        $this->assertDatabaseHas('item_user', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'deleted_at' => now(),
        ]);

        $this->assertDatabaseHas('item_user', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'deleted_at' => null,
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

        $command = Command::create([
            'class' => 'firemaking',
            'method' => 'burn',
            'verb' => 'burning',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/firemaking/burn', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'There are no logs in your inventory to burn!',
        ]);
    }
}
