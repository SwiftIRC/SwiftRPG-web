<?php

namespace App\Map;

use App\Models\MoveLog;
use App\Models\Tile;
use App\Models\User;
use function PHPUnit\Framework\isNull;
use Illuminate\Http\JsonResponse;

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

    public function get_adjacent_tile(Tile $tile, string $direction): ?Tile
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

        if (isNull($new_tile->discovered_by)) {
            $new_tile->discovered_by = $user->id;
            $new_tile->discovered_at = now();
            $new_tile->save();
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

    public function look(User $user): ?JsonResponse
    {
        $tile = Tile::where('id', $user->tile_id)->first();

        $tile->npcs = $tile->npcs()->get();
        $tile->edges = $tile->edges()->get();
        $tile->terrain = $tile->terrain()->get();
        $tile->buildings = $tile->buildings()->get();

        return response()->json($tile);
    }

    public function look_at(User $user, string $direction): ?JsonResponse
    {
        $tile = Tile::where('id', $user->tile_id)->first();

        $adjacent_tile = $this->get_adjacent_tile($tile, $direction);

        if (!$adjacent_tile || !$this->check_if_edge_is_road($tile, $direction)) {
            return response()->json(['error' => 'There is no road in that direction.'], 403);
        }

        $adjacent_tile->terrain = $adjacent_tile->terrain()->first();

        return response()->json($adjacent_tile);
    }

    public function npcs(User $user): ?JsonResponse
    {
        return response()->json(Tile::where('id', $user->tile_id)->first()->npcs()->get());
    }

    public function buildings(User $user): ?JsonResponse
    {
        return response()->json(Tile::where('id', $user->tile_id)->first()->buildings()->get());
    }
}
