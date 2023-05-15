<?php

namespace App\Map;

use App\Http\Response\Building as ResponseBuilding;
use App\Http\Response\Edge;
use App\Http\Response\Npc as ResponseNpc;
use App\Models\Building;
use App\Models\MoveLog;
use App\Models\Npc;
use App\Models\Occupation;
use App\Models\Skill;
use App\Models\Tile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use RangeException;

class Move
{
    public function check_if_edge_is_road(Tile $tile, string $direction): int
    {
        $edge = $tile->edges()->where('direction', $direction)->first();

        return $edge ? $edge->pivot->is_road : 0;
    }

    public function check_if_adjacent_edge_is_road(Tile $tile, string $direction): int
    {
        $adjacent_tile = $this->get_adjacent_tile($tile, $direction);

        return $adjacent_tile ? $this->check_if_edge_is_road($adjacent_tile, $this->invert_direction($direction)) : 0;
    }

    public function get_adjacent_tile(Tile $tile, string $direction):  ? Tile
    {
        $x = $tile->x;
        $y = $tile->y;

        switch ($direction) {
            case 'north' :
                $y++;
                break;
            case 'east':
                $x++;
                break;
            case 'south':
                $y--;
                break;
            case 'west':
                $x--;
                break;
        }

        return Tile::where('x', $x)->where('y', $y)->first();
    }

    public function invert_direction($direction)
    {
        $directions = [
            'north' => 'south',
            'east' => 'west',
            'south' => 'north',
            'west' => 'east',
        ];

        return $directions[$direction];
    }

    public function get_adjacent_edge(Tile $tile, string $direction)
    {
        $x = $tile->x;
        $y = $tile->y;

        switch ($direction) {
            case 'north':
                $y++;
                break;
            case 'east':
                $x++;
                break;
            case 'south':
                $y--;
                break;
            case 'west':
                $x--;
                break;
        }

        $inverted_direction = $this->invert_direction($direction);

        $adjacent_tile = Tile::where('x', $x)->where('y', $y)->first();
        if (!is_null($adjacent_tile)) {
            $adjacent_edge = $adjacent_tile->edges()->where('direction', $inverted_direction)->first();

            return $adjacent_edge;
        }
        return false;
    }

    public function move(User $user, string $direction)
    {
        $current_tile = $user->tile()->first();

        if (!$this->check_if_edge_is_road($current_tile, $direction)) {
            return ['error' => 'There is no road in that direction.'];
        }

        $x = $current_tile->x;
        $y = $current_tile->y;

        switch ($direction) {
            case 'north':
                $y++;
                break;
            case 'east':
                $x++;
                break;
            case 'south':
                $y--;
                break;
            case 'west':
                $x--;
                break;
        }

        $new_tile = Tile::where('x', $x)->where('y', $y)->first();

        if (is_null($new_tile->discovered_by)) {
            $new_tile->discovered_by = $user->id;
            $new_tile->discovered_at = now();
            $new_tile->save();

            $user->addXp(Skill::firstWhere('name', 'agility')->id, $new_tile->just_discovered);

            // Add NPCs and buildings to the tile
            $num_building = rand(0, 5);
            $num_npcs = rand(0, 2) * $num_building + rand(0, 6);

            $all_buildings = Building::all();
            $buildings = [];
            for ($i = 0; $i < $num_building; $i++) {
                $building = $all_buildings->random();
                $new_tile->buildings()->attach($building->id);
                array_push($buildings, $building);
            }

            $available_occupations = [];
            foreach ($buildings as $building) {
                $zones = $building->zones;
                if (is_null($zones)) {
                    continue;
                }
                $zone = $zones->first();
                $occupations = $zone->occupations()->get();
                if (count($occupations) > 0) {
                    $npc = Npc::factory()->create([
                        'occupation_id' => $occupations->random()->id,
                    ]);
                    array_push($available_occupations, $npc->occupation_id);
                    $new_tile->npcs()->attach($npc); // Does this duplicate the NPC?
                    $building->npcs()->attach($npc);
                    $num_npcs--;
                }
            }

            for (; $num_npcs > 0; $num_npcs--) {
                $npc = Npc::factory()->create();
                $npc->occupation_id = Occupation::inRandomOrder()->first()->id;
                $npc->save();
                $new_tile->npcs()->attach($npc);
            }

            // for ($i = 0; $i < $num_npcs; $i++) {
            //     $chance_for_building = rand(0, 100);
            //     $npc = Npc::generate()->first();
            //     $new_tile->npcs()->attach($npc->id);
            //     if ($chance_for_building < 75) {
            //         $building = Building::generate()->first();
            //         $new_tile->buildings()->attach($building->id);
            //         $building->npcs()->attach($npc->id);
            //     }
            // }
        }

        $current_tile->last_disturbed = now();
        $current_tile->save();

        $user->tile_id = $new_tile->id;
        $user->save();

        MoveLog::create([
            'user_id' => $user->id,
            'old_tile_id' => $current_tile->id,
            'new_tile_id' => $new_tile->id,
        ]);

        return $new_tile;
    }

    public function look(User $user):  ? Tile
    {
        $tile = Tile::firstWhere('id', $user->tile_id);

        $tile->npcs = $tile->npcs()->get()->map(function ($npc) {
            return (new ResponseNpc($npc))->toArray();
        });
        $tile->edges = $tile->edges()->get()->map(function ($edge) {
            return (new Edge($edge))->toArray();
        });
        $tile->terrain = $tile->terrain()->first();
        $tile->buildings = $tile->buildings()->get()->map(function ($building) {
            return (new ResponseBuilding($building))->toArray();
        });

        return $tile;
    }

    public function look_at(User $user, string $direction) :  ? Tile
    {
        $tile = Tile::firstWhere('id', $user->tile_id);

        $adjacent_tile = $this->get_adjacent_tile($tile, $direction);

        if (!$adjacent_tile || !$this->check_if_edge_is_road($tile, $direction)) {
            throw new RangeException('There is no road in that direction.');
        }

        $adjacent_tile->npcs = $adjacent_tile->npcs()->get()->map(function ($npc) {
            return (new ResponseNpc($npc))->toArray();
        });
        $adjacent_tile->edges = $adjacent_tile->edges()->get()->map(function ($edge) {
            return (new Edge($edge))->toArray();
        });
        $adjacent_tile->terrain = $adjacent_tile->terrain()->first();
        $adjacent_tile->buildings = $adjacent_tile->buildings()->get()->map(function ($building) {
            return (new ResponseBuilding($building))->toArray();
        });

        return $adjacent_tile;
    }

    public function npcs(User $user) :  ? Collection
    {
        $npcs = Tile::firstWhere('id', $user->tile_id)->npcs()->get()->each(function ($npc) {
            $npc->occupation = $npc->occupation()->first();
            $npc->skills = $npc->skills()->get();
        });

        return $npcs;
    }

    public function buildings(User $user) :  ? Collection
    {
        return Tile::firstWhere('id', $user->tile_id)->buildings()->get();
    }
}
