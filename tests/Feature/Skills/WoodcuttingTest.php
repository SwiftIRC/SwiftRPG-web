<?php

namespace Tests\Feature\Skills;

use Tests\TestCase;
use App\Models\Item;
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
        $user = User::factory()->create();
        Inventory::factory()->create([
            'user_id' => $user->id,
        ]);
        Item::factory()->create([
            'name' => 'Logs',
        ]);

        $response = $this->actingAs($user)->post('/api/woodcutting/chop', [], ['X-Bot-Token' => config('app.token')]);

        $response->assertStatus(200);
    }
}
