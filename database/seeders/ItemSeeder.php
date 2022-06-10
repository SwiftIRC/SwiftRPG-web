<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'user_id' => 1,
            'name' => 'Rusty Sword',
            'description' => 'A rusty sword',
            'weight' => 1,
            'interactive' => true,
            'wieldable' => true,
            'throwable' => false,
            'wearable' => false,
            'consumable' => false,
            'durability' => 100,
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'Rusty Sword',
            'description' => 'A rusty sword',
            'weight' => 1,
            'interactive' => true,
            'wieldable' => true,
            'throwable' => false,
            'wearable' => false,
            'consumable' => false,
            'durability' => 100,
        ]);
    }
}
