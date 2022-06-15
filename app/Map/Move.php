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

    public function check_if_adjacent_edge_is_road(Tile $tile, string $direction)
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

            return $adjacent_edge->pivot->is_road;
        }
        return false;
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

            $user->x = $x;
            $user->y = $y;
            $user->save();

            $new_tile = Tile::where('x', $x)->where('y', $y)->first();
            if (!$new_tile) {
                $new_tile = Tile::create([
                    'x' => $x,
                    'y' => $y,
                    'psuedo_id' => $x . ',' . $y,
                ]);

                $edges = [
                    Edge::create([
                        'name' => 'north',
                        'direction' => random_int(0, 1) == 1 ? true : $this->check_if_adjacent_edge_is_road($new_tile, 'north'),
                    ]),
                    Edge::create([
                        'name' => 'east',
                        'direction' => random_int(0, 1) == 1 ? true : $this->check_if_adjacent_edge_is_road($new_tile, 'east'),
                    ]),
                    Edge::create([
                        'name' => 'south',
                        'direction' => random_int(0, 1) == 1 ? true : $this->check_if_adjacent_edge_is_road($new_tile, 'south'),
                    ]),
                    Edge::create([
                        'name' => 'west',
                        'direction' => random_int(0, 1) == 1 ? true : $this->check_if_adjacent_edge_is_road($new_tile, 'west'),
                    ]),
                ];

                foreach ($edges as $edge) {
                    $new_tile->edges()->attach($edge);
                }
            }
            return $new_tile;
        }
        return response()->json(['error' => 'You cannot move in that direction.'], 403);
    }
}
