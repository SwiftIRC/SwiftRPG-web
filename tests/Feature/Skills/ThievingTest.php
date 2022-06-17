<?php

namespace Tests\Feature\Skills;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Tile;
use App\Models\User;
use App\Models\Inventory;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThievingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Inventory::flushEventListeners();
    }

    public function test_user_can_pickpocket()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.pickpocket',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'thieving' => 5,
        ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'gold' => 5,
        ]);
    }

    public function test_user_can_steal()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(10),
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.steal',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'thieving' => 10 + level_to_xp(10),
        ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'gold' => 10,
        ]);
    }

    public function test_user_cannot_steal()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(403);
    }

    public function test_user_can_pilfer()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(20),
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.pilfer',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'thieving' => 50 + level_to_xp(20),
        ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'gold' => 50,
        ]);
    }

    public function test_user_cannot_pilfer()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(403);
    }

    public function test_user_can_plunder()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(30),
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.plunder',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'thieving' => 100 + level_to_xp(30),
        ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'gold' => 100,
        ]);
    }

    public function test_user_cannot_plunder()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);
        $inventory = Inventory::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(403);
    }
}
