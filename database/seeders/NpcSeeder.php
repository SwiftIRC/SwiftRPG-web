<?php

namespace Database\Seeders;

use App\Models\Npc;
use App\Models\Tile;
use App\Models\Zone;
use App\Models\Building;
use App\Models\Occupation;
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
                'name' => 'Chef Isaac',
                'description' => 'A highly skilled chef. He is a bit of a stickler for the quality of his food. Prefers to cook pork.',
                'occupation_id' => Occupation::create([
                    'name' => 'Chef',
                    'description' => 'A chef by nature.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Farmer John',
                'description' => 'An experienced farmer, born and raised',
                'occupation_id' => Occupation::create([
                    'name' => 'Farmer',
                    'description' => 'A person who works the farm.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Priest Peter',
                'description' => 'A priest of the church. He speaks in foreign tongues and wears a pendant with what looks like a squid.',
                'occupation_id' => Occupation::create([
                    'name' => 'Priest',
                    'description' => 'A person who lives and works in the church.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Garry',
                'description' => 'A very friendly person. He seems to know what he is talking about.',
                'occupation_id' => Occupation::create([
                    'name' => 'Guide',
                    'description' => 'A person who offers guidance.',
                ])->id,
            ]),
        ];

        foreach ($npcs as $npc) {
            $building->npcs()->attach($npc);
        }

        $tile->buildings()->attach($building);

        // Npc::createMany([
        //     [
        //         'name' => 'Bartender',
        //         'Description' => 'A bartender.',
        //     ],
        //     [
        //         'name' => 'Guard',
        //         'Description' => 'A guard.',
        //     ]
        // ]);
    }
}
