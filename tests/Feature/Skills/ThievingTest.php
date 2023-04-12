<?php

namespace Tests\Feature\Skills;

use App\Models\Building;
use App\Models\Command;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThievingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_can_pickpocket()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(50),
        ]);

        $command = Command::create([
            'class' => 'thieving',
            'method' => 'pickpocket',
            'verb' => 'pickpocketing',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 0,
            'thieving' => level_to_xp(50),
        ]);

        $this->artisan('tick:process');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 5,
            'thieving' => level_to_xp(50) + 5,
        ]);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);
    }

    public function test_user_cannot_pickpocket()
    {
        $tile = Tile::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
        ]);

        $npcs = $tile->npcs()->get();
        for ($i = 0; $i < $npcs->count(); $i++) {
            $tile->npcs()->detach($npcs[$i]);
        }

        $command = Command::create([
            'class' => 'thieving',
            'method' => 'pickpocket',
            'verb' => 'pickpocketing',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 0,
            'thieving' => 0,
        ]);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
            'message' => "{\"error\":\"You failed to pickpocket because there was nobody around! Check a building?\"}",
        ]);
    }

    public function test_user_can_steal()
    {
        $tile = Tile::all()->first();
        $building = Building::all()->first();
        $user = User::factory()->create([
            'tile_id' => $tile->id,
            'building_id' => $building->id,
            'thieving' => level_to_xp(10),
        ]);

        $command = Command::create([
            'class' => 'thieving',
            'method' => 'steal',
            'verb' => 'stealing',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 10,
            'thieving' => 10 + level_to_xp(10),
        ]);
    }

    public function test_user_cannot_steal()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);

        Command::create([
            'class' => 'thieving',
            'method' => 'steal',
            'verb' => 'stealing',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);
    }

    public function test_user_can_pilfer()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(20),
        ]);

        $command = Command::create([
            'class' => 'thieving',
            'method' => 'pilfer',
            'verb' => 'pilfering',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 50,
            'thieving' => 50 + level_to_xp(20),
        ]);
    }

    public function test_user_cannot_pilfer()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);
    }

    public function test_user_can_plunder()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(30),
        ]);

        $command = Command::create([
            'class' => 'thieving',
            'method' => 'plunder',
            'verb' => 'plundering',
            'ticks' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 100,
            'thieving' => 100 + level_to_xp(30),
        ]);
    }

    public function test_user_cannot_plunder()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);
    }
}
