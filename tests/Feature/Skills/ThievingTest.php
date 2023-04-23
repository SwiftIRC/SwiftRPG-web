<?php

namespace Tests\Feature\Skills;

use App\Models\Command;
use App\Models\Item;
use App\Models\Skill;
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
        $user = User::factory()->create();

        $command = Command::where('class', 'thieving')->where('method', 'pickpocket')->first();

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);
        $thieving = Skill::firstWhere('name', 'thieving');

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseMissing('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $thieving->id,
            'quantity' => 0,
        ]);

        $gold = Item::firstWhere('name', 'Gold');

        $this->assertDatabaseMissing('item_user', [
            'user_id' => $user->id,
            'item_id' => $gold->id,
        ]);

        $this->artisan('tick:process');

        $this->assertDatabaseCount('item_user', 5);

        $this->assertDatabaseHas('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $thieving->id,
            'quantity' => 5,
        ]);
    }

    public function test_user_cannot_pickpocket()
    {
        $tile = Tile::firstWhere('psuedo_id', '0,0');
        $user = User::factory()->create();

        $npcs = $tile->npcs()->get();
        for ($i = 0; $i < $npcs->count(); $i++) {
            $tile->npcs()->detach($npcs[$i]);
        }

        $command = Command::where('class', 'thieving')->where('method', 'pickpocket')->first();

        $response = $this->actingAs($user)->post('/api/thieving/pickpocket', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $thieving = Skill::firstWhere('name', 'thieving');

        $this->assertDatabaseMissing('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $thieving->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseMissing('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
            'metadata->failure' => "You failed to pickpocket because there was nobody around! Check a building?",
        ]);
    }

    // public function test_user_can_steal()
    // {
    //     $tile = Tile::all()->first();
    //     $building = Building::all()->first();
    //     $user = User::factory()->create([
    //         'tile_id' => $tile->id,
    //         'building_id' => $building->id,
    //         'thieving' => level_to_xp(10),
    //     ]);

    //     $command = Command::create([
    //         'class' => 'thieving',
    //         'method' => 'steal',
    //         'verb' => 'stealing',
    //         'ticks' => 1,
    //     ]);

    //     $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

    //     $response->assertStatus(200);

    //     $this->assertDatabaseHas('command_logs', [
    //         'user_id' => $user->id,
    //         'command_id' => $command->id,
    //     ]);

    //     $this->assertDatabaseHas('users', [
    //         'id' => $user->id,
    //         'gold' => 10,
    //         'thieving' => 10 + level_to_xp(10),
    //     ]);
    // }

    // public function test_user_cannot_steal()
    // {
    //     $user = User::factory()->create([
    //         'tile_id' => Tile::all()->first()->id,
    //     ]);

    //     Command::create([
    //         'class' => 'thieving',
    //         'method' => 'steal',
    //         'verb' => 'stealing',
    //         'ticks' => 1,
    //     ]);

    //     $response = $this->actingAs($user)->post('/api/thieving/steal', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

    //     $response->assertStatus(200);
    // }

    // public function test_user_can_pilfer()
    // {
    //     $user = User::factory()->create([
    //         'tile_id' => Tile::all()->first()->id,
    //         'thieving' => level_to_xp(20),
    //     ]);

    //     $command = Command::create([
    //         'class' => 'thieving',
    //         'method' => 'pilfer',
    //         'verb' => 'pilfering',
    //         'ticks' => 1,
    //     ]);

    //     $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

    //     $response->assertStatus(200);

    //     $this->assertDatabaseHas('command_logs', [
    //         'user_id' => $user->id,
    //         'command_id' => $command->id,
    //     ]);

    //     $this->assertDatabaseHas('users', [
    //         'id' => $user->id,
    //         'gold' => 50,
    //         'thieving' => 50 + level_to_xp(20),
    //     ]);
    // }

    // public function test_user_cannot_pilfer()
    // {
    //     $user = User::factory()->create([
    //         'tile_id' => Tile::all()->first()->id,
    //     ]);

    //     $response = $this->actingAs($user)->post('/api/thieving/pilfer', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

    //     $response->assertStatus(200);
    // }

    // public function test_user_can_plunder()
    // {
    //     $user = User::factory()->create([
    //         'tile_id' => Tile::firstWhere('psuedo_id', '0,0')->id,
    //         'thieving' => level_to_xp(30),
    //     ]);

    //     $command = Command::where('class', 'thieving')->where('method', 'plunder')->first();

    //     $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

    //     $response->assertStatus(200);

    //     $this->assertDatabaseHas('command_logs', [
    //         'user_id' => $user->id,
    //         'command_id' => $command->id,
    //     ]);

    //     $this->assertDatabaseHas('users', [
    //         'id' => $user->id,
    //         'gold' => 100,
    //         'thieving' => 100 + level_to_xp(30),
    //     ]);
    // }

    // public function test_user_cannot_plunder()
    // {
    //     $user = User::factory()->create([
    //         'tile_id' => Tile::all()->first()->id,
    //     ]);

    //     $response = $this->actingAs($user)->post('/api/thieving/plunder', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

    //     $response->assertStatus(200);
    // }
}
