<?php

namespace Tests\Feature\Skills;

use Tests\TestCase;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Building;

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

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 5,
            'thieving' => level_to_xp(50) + 5,
        ]);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.pickpocket',
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

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'gold' => 0,
            'thieving' => 0,
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

        $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.steal',
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

        $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(403);
    }

    public function test_user_can_pilfer()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(20),
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.pilfer',
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

        $response->assertStatus(403);
    }

    public function test_user_can_plunder()
    {
        $user = User::factory()->create([
            'tile_id' => Tile::all()->first()->id,
            'thieving' => level_to_xp(30),
        ]);

        $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command' => 'thieving.plunder',
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

        $response->assertStatus(403);
    }
}
