<?php

namespace Tests;

use App\Models\Client;
use App\Models\Skill;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        if (Skill::firstWhere('name', 'thieving')) {
            return;
        }
        $this->artisan('db:seed');
        Client::factory()->create([
            'client_id' => 'this-is-a-test',
        ]);

    }
}
