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
        $logs = Item::create([
            'name' => 'Logs',
            'description' => 'A bundle of logs.',
            'weight' => 2,
            'ticks' => 0.2,
            // 'interactive' => true,
            // 'wieldable' => false,
            // 'throwable' => false,
            // 'wearable' => false,
            // 'consumable' => false,
            // 'stackable' => true,
            // 'durability' => 100,
        ]);
        Item::create([
            'name' => 'Apple',
            'description' => 'A delicious red apple.',
            'weight' => 1,
            // 'interactive' => true,
            // 'wieldable' => true,
            // 'throwable' => false,
            // 'wearable' => false,
            // 'consumable' => false,
            // 'stackable' => false,
            // 'durability' => 100,
        ]);
        $ore = Item::create([
            'name' => 'Iron Ore',
            'description' => 'A piece of iron ore.',
            'weight' => 10,
            'ticks' => 1,
            // 'interactive' => true,
            // 'wieldable' => false,
            // 'throwable' => false,
            // 'wearable' => false,
            // 'consumable' => false,
            // 'stackable' => true,
            // 'durability' => 100,
        ]);
        $bar = Item::create([
            'name' => 'Iron Bar',
            'description' => 'A bar of iron.',
            'weight' => 10,
            'ticks' => 1 + $logs->ticks + $ore->ticks,
            // 'interactive' => true,
            // 'wieldable' => false,
            // 'throwable' => false,
            // 'wearable' => false,
            // 'consumable' => false,
            // 'stackable' => true,
            // 'durability' => 100,
        ]);
        $sword = Item::create([
            'name' => 'Iron Sword',
            'description' => 'A sword made of iron.',
            'weight' => 10,
            'ticks' => 1 + $bar->ticks,
            // 'interactive' => true,
            // 'wieldable' => true,
            // 'throwable' => false,
            // 'wearable' => false,
            // 'consumable' => false,
            // 'stackable' => false,
            // 'durability' => 100,
        ]);
        $durable_sword = Item::create([
            'name' => 'Durable Iron Sword',
            'description' => 'A hefty iron sword.',
            'weight' => 20,
            'ticks' => 1 + $sword->ticks * 2,
            // 'interactive' => true,
            // 'wieldable' => true,
            // 'throwable' => false,
            // 'wearable' => false,
            // 'consumable' => false,
            // 'stackable' => false,
            // 'durability' => 100,
        ]);
    }
}
