<?php

namespace Tests\Feature\Skills;

use App\Models\Command;
use App\Models\Item;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WoodcuttingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_chop()
    {
        $user = User::factory()->create();

        $item = Item::firstWhere('name', 'Logs');

        $command = Command::where('class', 'woodcutting')->where('method', 'chop')->first();
        $woodcutting = Skill::firstWhere('name', 'woodcutting');

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('command_logs', [
            'user_id' => $user->id,
            'command_id' => $command->id,
        ]);

        $this->assertDatabaseMissing('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $woodcutting->id,
            'quantity' => 0,
        ]);

        $this->artisan('tick:process');

        $this->assertDatabaseCount('item_user', 5);

        $this->assertDatabaseHas('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $woodcutting->id,
            'quantity' => 5,
        ]);

    }

    public function test_user_cannot_chop()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Client-Id' => 'this-is-a-test', 'X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'failure',
            'metadata',
        ]);
    }
}
