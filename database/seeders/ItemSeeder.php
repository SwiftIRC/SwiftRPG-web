<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Effect;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventory = Inventory::create([
            'user_id' => 1,
            'gold' => 0,
            'size' => 5,
        ]);
        Inventory::create([
            'user_id' => 2,
            'gold' => 0,
            'size' => 5,
        ]);

        $items = [
            Item::create([
                'name' => 'Rusty Sword',
                'description' => 'A rusty sword',
                'weight' => 2,
                'interactive' => true,
                'wieldable' => true,
                'throwable' => false,
                'wearable' => false,
                'consumable' => false,
                'durability' => 5,
            ]),
            Item::create([
                'name' => 'Robust Sword',
                'description' => 'A robust sword',
                'weight' => 5,
                'interactive' => true,
                'wieldable' => true,
                'throwable' => false,
                'wearable' => false,
                'consumable' => false,
                'durability' => 55,
            ]),
            Item::create([
                'name' => 'Logs',
                'description' => 'A bundle of logs',
                'weight' => 2,
                'interactive' => true,
                'wieldable' => false,
                'throwable' => false,
                'wearable' => false,
                'consumable' => false,
                'stackable' => true,
                'durability' => 100,
            ])
        ];

        foreach ($items as $item) {
            $inventory->items()->attach($item);
            $inventory->items()->attach($items[2]);
        }

        $effect = Effect::create([
            'name' => 'Tetanus',
            'description' => 'The sword was rusty',
            'duration' => -1,
            'health_change' => -5,
            'mana_change' => 0,
            'stamina_change' => 0,
            'strength_change' => 0,
            'luck_change' => 0,
            'damage_change' => 0,
            'armor_change' => 0,
            'speed_change' => 0,
            'critical_chance' => 0,
            'critical_damage' => 0,
            'compounds' => false,
            'compound_chance' => 0,
        ]);

        $items[0]->effects()->attach($effect);
    }
}
