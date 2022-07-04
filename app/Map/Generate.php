<?php

namespace App\Map;

use App\Map\Move;
use App\Models\Edge;
use App\Models\Tile;
use App\Models\Terrain;

class Generate
{
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
                    if (app(Move::class)->check_if_adjacent_edge_is_road($connected_tile, $direction)) {
                        $found_road = true;
                        break 2;
                    }
                }
            }

            if (!$found_road) {
                $this->fill_in_with_water($internal_tile);

                foreach ($connected_tiles as $connected_tile) {
                    $this->fill_in_with_water($connected_tile);
                }
            }
        }
    }

    public function fill_in_with_water(Tile $tile)
    {
        if (Tile::where('x', $tile->x)->where('y', $tile->y)->count() > 0) {
            return;
        }

        $water = Terrain::where('name', 'Water')->first();

        $tile->psuedo_id = $tile->x . ',' . $tile->y;
        $tile->terrain_id = $water->id;
        $tile->save();

        $directions = ['north', 'east', 'south', 'west'];

        $edge = Edge::where('terrain_id', $water->id)->first();

        foreach ($directions as $direction) {
            $adjacent_edge = app(Move::class)->get_adjacent_edge($tile, $direction);

            if ($adjacent_edge) {
                $adjacent_edge->terrain_id = $water->id;
                $adjacent_edge->save();
            }

            $tile->edges()->attach($edge, [
                'direction' => $direction,
            ]);
        }

        return $tile;
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

    public function follow_roads(Tile $starting_tile, array $processed_tiles = [])
    {
        $directions = ['north', 'east', 'south', 'west'];
        $processed_tiles[$starting_tile->x][$starting_tile->y] = $starting_tile;

        foreach ($directions as $direction) {
            if (app(Move::class)->check_if_edge_is_road($starting_tile, $direction)) {
                $adjacent_tile = $this->get_adjacent_missing_tile($starting_tile, $direction);
                $terrain_id = $starting_tile->edges()->where('direction', $direction)->first()->terrain_id;

                if ($adjacent_tile && !in_array($adjacent_tile, $processed_tiles)) {
                    $adjacent_tile->terrain_id = $terrain_id;
                    $this->generate_tile($adjacent_tile);

                    $processed_tiles = $this->follow_roads($adjacent_tile, $processed_tiles);
                }
            }
        }

        return $processed_tiles;
    }

    public function generate_tile(Tile $tile)
    {
        $tile->psuedo_id = $tile->x . ',' . $tile->y;
        if (!$tile->terrain_id) {
            $tile->terrain_id = 1;
        }

        $trees = random_int(0, 100);
        $tile->max_trees = $trees;
        $tile->available_trees = $trees;

        $tile->save();

        $directions = ['north', 'east', 'south', 'west'];

        foreach ($directions as $direction) {
            $adjacent_edge = app(Move::class)->get_adjacent_edge($tile, $direction);

            $is_road = false;
            if ($adjacent_edge) {
                $edge = $adjacent_edge;
                $is_road = $adjacent_edge->pivot->is_road;
            } else {
                $edge = Edge::all()->random();
                $is_road = random_int(0, 100) <= 45;
            }

            $edge->terrain_id = $tile->terrain_id;

            $tile->edges()->attach($edge, [
                'direction' => $direction,
                'is_road' => $is_road,
            ]);
        }
    }

    public function map()
    {
        $this->follow_roads(Tile::where('id', 1)->first());

        $this->fill_in_missing_tiles_if_isolated();

        return 0;
    }
}
