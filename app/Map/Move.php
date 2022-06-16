<?php

namespace App\Map;

use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;

class Move
{
    public function check_if_edge_is_road(Tile $tile, string $direction)
    {
        return $tile->edges()->where('direction', $direction)->first()->pivot->is_road;
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

        $inverted_directions = [
            'north' => 'south',
            'east' => 'west',
            'south' => 'north',
            'west' => 'east',
        ];
        $inverted_direction = $inverted_directions[$direction];

        $adjacent_tile = Tile::where('x', $x)->where('y', $y)->first();
        if ($adjacent_tile) {
            $adjacent_edge = $adjacent_tile->edges()->where('direction', $inverted_direction)->first();

            return $adjacent_edge;
        }
        return false;
    }

    public function check_if_adjacent_edge_is_road(Tile $tile, string $direction)
    {
        $edge = $this->get_adjacent_edge($tile, $direction);

        return $edge ? $edge->pivot->is_road : false;
    }

    public function move(User $user, string $direction)
    {
        $current_tile = Tile::where('x', $user->x)->where('y', $user->y)->first();

        if ($this->check_if_edge_is_road($current_tile, $direction)) {
            $x = $user->x;
            $y = $user->y;

            $directions = [
                'north' => false,
                'east' => false,
                'south' => false,
                'west' => false,
            ];

            $directions[$direction] = true;

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
            if (!$new_tile) {
                $tree_count = rand(0, 100);
                $discovered_tile = Tile::create([
                    'discovered_by' => $user->id,
                    'x' => $x,
                    'y' => $y,
                    'psuedo_id' => $x . ',' . $y,
                    'max_trees' => $tree_count,
                    'available_trees' => $tree_count,
                ]);

                foreach (array_keys($directions) as $direction) {
                    $adjacent_edge = $this->get_adjacent_edge($discovered_tile, $direction);

                    if ($adjacent_edge) {
                        $discovered_tile->edges()->attach(
                            Edge::where('id', $adjacent_edge->id)->first(),
                            [
                                'is_road' => random_int(0, 1) == 1 ? true : $adjacent_edge->pivot->is_road,
                                'direction' => $direction,
                            ]
                        );
                    } else {
                        $discovered_tile->edges()->attach(
                            Edge::all()->random(),
                            [
                                'is_road' => random_int(0, 1) == 1 ? true : false,
                                'direction' => $direction,
                            ]
                        );
                    }
                }

                $new_tile = Tile::where('x', $x)->where('y', $y)->first();
            }

            $user->x = $x;
            $user->y = $y;
            $user->save();

            return $new_tile;
        }
        return response()->json(['error' => 'There is no road in that direction.'], 403);
    }

    public function look(User $user)
    {
        $tile = Tile::where('x', $user->x)->where('y', $user->y)->first();

        $tile->npcs = $tile->npcs()->get();
        $tile->edges = $tile->edges()->get();
        $tile->terrains = $tile->terrains()->get();
        $tile->buildings = $tile->buildings()->get();

        return response()->json($tile);
    }

    public function npcs(User $user)
    {
        return response()->json(Tile::where('x', $user->x)->where('y', $user->y)->first()->npcs()->get());
    }

    public function buildings(User $user)
    {
        return response()->json(Tile::where('x', $user->x)->where('y', $user->y)->first()->buildings()->get());
    }
}
