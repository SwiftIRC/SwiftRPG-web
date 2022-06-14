<?php

namespace Database\Seeders;

use App\Models\Npc;
use App\Models\Tile;
use App\Models\Zone;
use App\Models\Building;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NpcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tile = Tile::where('psuedo_id', '0-0')->first();
        $zone = Zone::create([
            'name' => 'Farmhouse',
            'description' => 'A test zone',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => false,
            'is_bed' => false,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $building = Building::create([
            'name' => 'Farmhouse',
            'description' => 'An average sized farmhouse.',
            'zone_id' => $zone->id,
        ]);

        $npcs = [
            Npc::create([
                'name' => 'Chef',
                'description' => 'A highly skilled chef.',
            ]),
            Npc::create([
                'name' => 'Farmer',
                'description' => 'An experienced farmer.',
            ])
        ];

        $building->npcs()->attach($npcs[0]);
        $building->npcs()->attach($npcs[1]);

        $tile->buildings()->attach($building);
    }
}
