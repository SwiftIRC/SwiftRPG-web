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

    public function get_adjacent_missing_tile(Tile $tile, string $direction)
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

        if ($tile = Tile::where('x', $x)->where('y', $y)->first()) {
            return;
        }
        $adjacent_tile = new Tile();
        $adjacent_tile->x = $x;
        $adjacent_tile->y = $y;

        return $adjacent_tile;
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

        return $edge ? $edge->pivot->is_road : $edge;
    }

    public function fill_in_missing_tiles_if_isolated()
    {
        $tiles = Tile::all();
        $tile_coords = [];
        $invalid_coords = [];
        $max_x = 0;
        $min_x = 0;
        $max_y = 0;
        $min_y = 0;

        foreach ($tiles as $tile) {
            $tile_coords[$tile->x][$tile->y] = $tile;

            if ($tile->x > $max_x) {
                $max_x = $tile->x;
            } elseif ($tile->x < $min_x) {
                $min_x = $tile->x;
            }
            if ($tile->y > $max_y) {
                $max_y = $tile->y;
            } elseif ($tile->y < $min_y) {
                $min_y = $tile->y;
            }
        }

        $max_x++;
        $min_x--;
        $max_y++;
        $min_y--;

        for ($x = $min_x; $x <= $max_x; $x++) {
            $invalid_coords[$x][$max_y] = true;
            $invalid_coords[$x][$min_y] = true;
        }
        for ($y = $min_y; $y <= $max_y; $y++) {
            $invalid_coords[$max_x][$y] = true;
            $invalid_coords[$min_x][$y] = true;
        }

        $empty_tiles = $this->find_all_empty_tiles($max_x, $max_y, $min_x, $min_y, $tile_coords);

        $external_empty_tiles = $this->find_all_connected_empty_tiles($empty_tiles, $tile_coords);
        $internal_tiles = array_diff($empty_tiles, $external_empty_tiles);

        info("Internal tiles: " . count($internal_tiles));
    }

    public function find_all_empty_tiles(int $max_x, int $max_y, int $min_x, int $min_y, array $tile_coords)
    {
        $empty_tiles = [];
        for ($x = $min_x; $x <= $max_x; $x++) {
            for ($y = $min_y; $y <= $max_y; $y++) {
                if (!isset($tile_coords[$x][$y])) {
                    $tile = new Tile();
                    $tile->x = $x;
                    $tile->y = $y;

                    $empty_tiles[] = $tile;
                }
            }
        }
        return $empty_tiles;
    }

    public function find_all_connected_empty_tiles(array $empty_tiles, array $tile_coords): array
    {
        $connected_tiles = [];

        $search_tile = $empty_tiles[count($empty_tiles) - 1];

        return $this->iterate_over_all_connected_empty_tiles($search_tile, $empty_tiles, $connected_tiles);
    }

    public function iterate_over_all_connected_empty_tiles(Tile $search_tile, array $empty_tiles, array $connected_tiles): array
    {
        $tiles = $this->get_adjacent_missing_tiles($search_tile, $empty_tiles, $connected_tiles);
        if (!empty($tiles)) {
            $connected_tiles = array_merge($connected_tiles, $tiles);

            foreach ($tiles as $tile) {
                $connected_tiles = $this->iterate_over_all_connected_empty_tiles($tile, $empty_tiles, $connected_tiles);
            }
        }

        return $connected_tiles;
    }

    public function get_adjacent_missing_tiles(Tile $tile, array $empty_tiles, array $connected_tiles): array
    {
        $directions = ['north', 'east', 'south', 'west'];
        $tiles = [];

        foreach ($directions as $direction) {
            $adjacent_tile = $this->get_adjacent_missing_tile($tile, $direction);
            if ($adjacent_tile && in_array($adjacent_tile, $empty_tiles) && !in_array($adjacent_tile, $connected_tiles)) {
                $tiles[] = $adjacent_tile;
            }
        }


        return $tiles;
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

        $this->fill_in_missing_tiles_if_isolated();

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
        return response()->json(Tile::where('id', $user->tile_id)->first()->npcs()->get());
    }

    public function buildings(User $user)
    {
        return response()->json(Tile::where('id', $user->tile_id)->first()->buildings()->get());
    }
}
