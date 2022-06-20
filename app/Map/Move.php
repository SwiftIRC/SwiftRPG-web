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
        if ($adjacent_tile) {
            $adjacent_edge = $adjacent_tile->edges()->where('direction', $inverted_direction)->first();

            return $adjacent_edge;
        }
        return false;
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

        app(Move::class)->fill_in_missing_tiles_if_isolated();

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