<?php

namespace Tests;

use App\Models\Npc;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\Zone;
use App\Models\Terrain;
use App\Models\Building;
use App\Models\Occupation;
use Database\Factories\BuildingFactory;
use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Terrain::factory()->create();
        $terrain = Terrain::all()->first();
        $edges = [
            Edge::create([
                'name' => 'north',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'east',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'south',
                'terrain_id' => $terrain->id,
            ]),
            Edge::create([
                'name' => 'west',
                'terrain_id' => $terrain->id,
            ]),
        ];
        $tile = Tile::factory()->create([
            'terrain_id' => $terrain->id,
        ]);
        foreach ($edges as $edge) {
            $tile->edges()->attach($edge, ['is_road' => true, 'direction' => $edge->name]);
        }

        $tile->npcs()->attach(Npc::create([
            'name' => 'Chef Isaac',
            'description' => 'A highly skilled chef. He is a bit of a stickler for the quality of his food. Prefers to cook pork.',
            'occupation_id' => Occupation::create([
                'name' => 'Chef',
                'description' => 'A talented cook by nature.',
            ])->id,
        ]));

        $zone = ZoneFactory::new()->create();
        $building = BuildingFactory::new()->create([
            'zone_id' => $zone->id,
        ]);

        $building->npcs()->create([
            'name' => 'Gibb Wyon',
            'description' => 'An experienced farmer, born and raised. His clothing looks worn.',
            'occupation_id' => Occupation::create([
                'name' => 'Farmer',
                'description' => 'Works the farm.',
            ])->id,
        ]);

        $tile->buildings()->attach($building);

        // $farmhouse = Building::create([
        //     'name' => 'Farmhouse',
        //     'description' => 'An average sized farmhouse.',
        //     'zone_id' => Zone::create([
        //         'name' => 'Farmhouse',
        //         'description' => 'Generic farmhouses.',
        //         'is_shop' => false,
        //         'is_pub' => false,
        //         'is_house' => false,
        //         'is_bed' => false,
        //         'is_accessible' => true,
        //         'is_locked' => false,
        //         'is_pilferable' => false,
        //     ])->id,
        // ]);

        // $tile->buildings()->attach($farmhouse);

        // $farmhouse->npcs()->create([
        //     'name' => 'Gibb Wyon',
        //     'description' => 'An experienced farmer, born and raised. His clothing looks worn.',
        //     'occupation_id' => Occupation::create([
        //         'name' => 'Farmer',
        //         'description' => 'Works the farm.',
        //     ])->id,
        // ]);

        $tile->available_trees = 15;
        $tile->max_trees = 15;
        $tile->save();
    }
}
