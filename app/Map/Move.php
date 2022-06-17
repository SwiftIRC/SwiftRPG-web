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

    public function get_adjacent_tile(Tile $tile, string $direction)
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

        return Tile::where('x', $x)->where('y', $y)->first();
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

    public function fill_in_isolated_tiles(Tile $tile)
    {
        $missing_tiles = $this->find_missing_tiles_from_border($tile);

        foreach ($missing_tiles as $missing_tile) {
            $this->fill_in_missing_tile_if_isolated($tile, $missing_tile);
        }
    }

    public function fill_in_missing_tile_if_isolated(Tile $tile, string $missing_direction)
    {
        $missing_x = $tile->x;
        $missing_y = $tile->y;

        switch ($missing_direction) {
            case 'north':
                $missing_y++;
                break;
            case 'east':
                $missing_x++;
                break;
            case 'south':
                $missing_y--;
                break;
            case 'west':
                $missing_x--;
                break;
        }

        $directions = ['north', 'east', 'south', 'west'];

        $inverted_directions = [
            'north' => 'south',
            'east' => 'west',
            'south' => 'north',
            'west' => 'east',
        ];

        foreach ($directions as $direction) {
            $inverted_direction = $inverted_directions[$direction];
            $x = $missing_x;
            $y = $missing_y;

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

            $adjacent_tile = Tile::where('x', $x)->where('y', $y)->first();

            if (!$adjacent_tile) {
                return;
            }
            $adjacent_edge = $adjacent_tile->edges()->where('direction', $inverted_direction)->first();

            if ($adjacent_edge->pivot->is_road) {
                return;
            }
        }

        Tile::create([
            'x' => $missing_x,
            'y' => $missing_y,
            'psuedo_id' => $missing_x . ',' . $missing_y,
        ]);
    }

    public function find_missing_tiles_from_border(Tile $tile)
    {
        $missing_directions = [];
        $directions = ['north', 'east', 'south', 'west'];

        foreach ($directions as $direction) {
            $adjacent_tile = $this->get_adjacent_tile($tile, $direction);
            if (!$adjacent_tile) {
                $missing_directions[] = $direction;
            }
        }

        return $missing_directions;
    }

    public function move(User $user, string $direction)
    {
        $current_tile = Tile::where('id', $user->tile_id)->first();

        if (!$this->check_if_edge_is_road($current_tile, $direction)) {
            return response()->json(['error' => 'There is no road in that direction.'], 403);
        }

        $x = $user->tile()->x;
        $y = $user->tile()->y;

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
                            'is_road' => $adjacent_edge->pivot->is_road,
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

        $user->tile_id = $new_tile->id;
        $user->save();

        $this->fill_in_isolated_tiles($new_tile);

        return $new_tile;
    }

    public function look(User $user)
    {
        $tile = Tile::where('id', $user->tile_id)->first();

        $tile->npcs = $tile->npcs()->get();
        $tile->edges = $tile->edges()->get();
        $tile->terrains = $tile->terrains()->get();
        $tile->buildings = $tile->buildings()->get();

        return response()->json($tile);
    }

    public function npcs(User $user)
    {
        return response()->json(Tile::where('id', $user->id)->first()->npcs()->get());
    }

    public function buildings(User $user)
    {
        return response()->json(Tile::where('id', $user->id)->first()->buildings()->get());
    }
}
