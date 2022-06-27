<?php

namespace App\Map;

use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;
use App\Models\MoveLog;
use App\Models\Terrain;

class Move
{
    public function check_if_edge_is_road(Tile $tile, string $direction)
    {
        $edge = $tile->edges()->where('direction', $direction)->first();

        return $edge ? $edge->pivot->is_road : false;
    }

    public function check_if_adjacent_edge_is_road(Tile $tile, string $direction)
    {
        $adjacent_tile = $this->get_adjacent_tile($tile, $direction);

        return $adjacent_tile ? $this->check_if_edge_is_road($adjacent_tile, $this->invert_direction($direction)) : false;
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

    public function invert_direction($direction)
    {
        switch ($direction) {
            case 'north':
                return 'south';
            case 'east':
                return 'west';
            case 'south':
                return 'north';
            case 'west':
                return 'east';
        }
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
        if ($adjacent_tile) {
            $adjacent_edge = $adjacent_tile->edges()->where('direction', $inverted_direction)->first();

            return $adjacent_edge;
        }
        return false;
    }

    public function fill_in_missing_tiles_if_isolated()
    {
        $tiles = Tile::all();
        $tile_coords = [];
        $invalid_coords = [];
        $directions = ['north', 'east', 'south', 'west'];
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

        $processed_tiles = [];
        foreach ($internal_tiles as $internal_tile) {
            if (in_array($internal_tile, $processed_tiles)) {
                continue;
            }
            $connected_tiles = $this->iterate_over_all_connected_empty_tiles($internal_tile, $internal_tiles, []);
            $processed_tiles = array_merge($processed_tiles, $connected_tiles);

            $found_road = false;
            foreach ($connected_tiles as $connected_tile) {
                foreach ($directions as $direction) {
                    if ($this->check_if_adjacent_edge_is_road($connected_tile, $direction)) {
                        $found_road = true;
                        break 2;
                    }
                }
            }
            if (!$found_road) {
                foreach ($connected_tiles as $connected_tile) {
                    $this->fill_in_with_water($connected_tile);
                }
            }
        }
    }

    public function fill_in_with_water(Tile $tile)
    {
        $water = Terrain::where('name', 'Water')->first();

        $tile->psuedo_id = $tile->x . ',' . $tile->y;
        $tile->terrain_id = $water->id;
        $tile->save();

        $directions = ['north', 'east', 'south', 'west'];

        $edge = Edge::where('terrain_id', $water->id)->first();

        foreach ($directions as $direction) {
            $adjacent_edge = $this->get_adjacent_edge($tile, $direction);
            $adjacent_edge->terrain_id = $water->id;
            $adjacent_edge->save();

            $tile->edges()->attach($edge, [
                'direction' => $direction,
            ]);
        }
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

        $search_tile = $empty_tiles[0];

        return $this->iterate_over_all_connected_empty_tiles($search_tile, $empty_tiles, $connected_tiles);
    }

    public function iterate_over_all_connected_empty_tiles(Tile $search_tile, array $empty_tiles, array $connected_tiles): array
    {
        $connected_tiles[] = $search_tile;
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
                'terrain_id' => Terrain::where('name', 'Grass')->first()->id, # TODO: make this random
            ]);

            foreach (array_keys($directions) as $direction) {
                $adjacent_edge = $this->get_adjacent_edge($discovered_tile, $direction);

                if ($adjacent_edge) {
                    $new_edge = Edge::where('id', $adjacent_edge->id)->first();
                    $new_edge_data = [
                        'is_road' => $adjacent_edge->pivot->is_road,
                        'direction' => $direction,
                    ];

                    // $new_terrain = $new_edge->terrains()->get();
                } else {
                    $new_edge = Edge::all()->random();
                    $new_edge_data = [
                        'is_road' => random_int(0, 1) == 1 ? true : false,
                        'direction' => $direction,
                    ];

                    // $new_terrain = Terrain::all()->random();
                }

                $discovered_tile->edges()->attach($new_edge, $new_edge_data);
            }

            $new_tile = Tile::where('x', $x)->where('y', $y)->first();
        }

        $user->tile_id = $new_tile->id;
        $user->save();

        $this->fill_in_missing_tiles_if_isolated();

        MoveLog::create([
            'user_id' => $user->id,
            'old_tile_id' => $current_tile->id,
            'new_tile_id' => $new_tile->id,
        ]);

        return $new_tile;
    }

    public function look(User $user)
    {
        $tile = Tile::where('id', $user->tile_id)->first();

        $tile->npcs = $tile->npcs()->get();
        $tile->edges = $tile->edges()->get();
        $tile->terrain = $tile->terrain()->get();
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
