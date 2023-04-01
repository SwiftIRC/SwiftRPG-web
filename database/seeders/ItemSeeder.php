<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            Item::create([
                'name' => 'Logs',
                'description' => 'A bundle of logs.',
                'weight' => 2,
                // 'interactive' => true,
                // 'wieldable' => false,
                // 'throwable' => false,
                // 'wearable' => false,
                // 'consumable' => false,
                // 'stackable' => true,
                // 'durability' => 100,
            ]),
            Item::create([
                'name' => 'Apple',
                'description' => 'A delicious red apple.',
                'weight' => 2,
                // 'interactive' => true,
                // 'wieldable' => true,
                // 'throwable' => false,
                // 'wearable' => false,
                // 'consumable' => false,
                // 'stackable' => false,
                // 'durability' => 100,
            ]),
        ];

    }
}
