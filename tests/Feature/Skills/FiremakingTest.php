<?php

namespace Tests\Feature\Skills;

use App\Models\Command;
use App\Models\Item;
use App\Models\Skill;
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
        $user = User::factory()->create();

        $item = Item::firstWhere('name', 'Logs');

        $user->items()->attach($item);
        $user->items()->attach($item);

        $command = Command::where('class', 'firemaking')->where('method', 'burn')->first();

        $response = $this->actingAs($user)->post('/api/firemaking/burn', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $firemaking = Skill::firstWhere('name', 'firemaking');
        $this->assertDatabaseMissing('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $firemaking->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseCount('item_user', 2);

        $this->artisan('tick:process');

        $this->assertDatabaseHas('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $firemaking->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseCount('item_user', 1);

        $this->assertDatabaseHas('item_user', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'deleted_at' => null,
        ]);
    }

    public function test_user_cannot_burn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/firemaking/burn', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $response->assertJson([
            'failure' => 'There are no logs in your inventory to burn!',
        ]);
    }
}
