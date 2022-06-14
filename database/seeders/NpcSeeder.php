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
        $tile2 = Tile::where('psuedo_id', '1-0')->first();
        $tile3 = Tile::where('psuedo_id', '0-1')->first();

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

        $tile->buildings()->attach($building);

        $npcs = [
            Npc::create([
                'name' => 'Chef Isaac',
                'description' => 'A highly skilled chef. He is a bit of a stickler for the quality of his food. Prefers to cook pork.',
                'occupation_id' => Occupation::create([
                    'name' => 'Chef',
                    'description' => 'A talented cook by nature.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Priest Peter',
                'description' => 'A priest of the church. He speaks in foreign tongues and wears a pendant with what looks like a squid.',
                'occupation_id' => Occupation::create([
                    'name' => 'Priest',
                    'description' => 'Lives and works in the church.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Asselin Alderman',
                'description' => 'A very friendly person. He is holding a heavy book and seems to know what he is talking about.',
                'occupation_id' => Occupation::create([
                    'name' => 'Guide',
                    'description' => 'Offers guidance.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Vicar Bertaut',
                'description' => 'A scar under his eye, and a beard that is a bit too long. The quality of his armor is lacking but he sports expensive jewelry.',
                'occupation_id' => Occupation::create([
                    'name' => 'Guard',
                    'description' => 'A pay-to-play mercenary.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Edrick Fryee',
                'description' => 'Wearing an unfamiliar animal skin, he plays a beautiful and unique string instrument of his own creation.',
                'occupation_id' => Occupation::create([
                    'name' => 'Bard',
                    'description' => 'Sing me a song, you\'re the music man.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Thistle Tatume',
                'description' => 'Mystical eyes look back at you, inviting you for a drink.',
                'occupation_id' => Occupation::create([
                    'name' => 'Bartender',
                    'description' => 'Serves you food and beverages, and maybe has heard a thing or two.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Sylvia Wescotte',
                'description' => 'A beautiful girl that appears to be poverty-stricken. She works hard and shares little information.',
                'occupation_id' => Occupation::create([
                    'name' => 'Barmaid',
                    'description' => 'Serves you food and beverages, and maybe has heard a thing or two.',
                ])->id,
            ]),
        ];

        $building->npcs()->create([
            'name' => 'Gibb Wyon',
            'description' => 'An experienced farmer, born and raised. His clothing looks worn.',
            'occupation_id' => Occupation::create([
                'name' => 'Farmer',
                'description' => 'Works the farm.',
            ])->id,
        ]);

        foreach ($npcs as $npc) {
            $tile->npcs()->attach($npc);
        };
        Occupation::create([
            'name' => 'Clerk',
            'description' => 'Works the cash register.',
        ]);
        Occupation::create([
            'name' => 'Cook',
            'description' => 'Cooks the food.',
        ]);
    }
}
