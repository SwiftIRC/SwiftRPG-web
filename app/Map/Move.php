<?php

namespace App\Map;

use App\Models\Edge;
use App\Models\Tile;
use App\Models\User;

class Move
{
    public function move(User $user, string $direction)
    {
        $current_tile = Tile::where('x', $user->x)->where('y', $user->y)->first();
        $edge = $current_tile->edges()->where('direction', $direction)->first();

        if ($edge->pivot->is_road) {
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

                $edges = [ // these directions are swapped intentionally
                    Edge::create([
                        'name' => 'north',
                        'direction' => random_int(0, 1) == 1 ? true : $directions['south'],
                    ]),
                    Edge::create([
                        'name' => 'east',
                        'direction' => random_int(0, 1) == 1 ? true : $directions['west'],
                    ]),
                    Edge::create([
                        'name' => 'south',
                        'direction' => random_int(0, 1) == 1 ? true : $directions['north'],
                    ]),
                    Edge::create([
                        'name' => 'west',
                        'direction' => random_int(0, 1) == 1 ? true : $directions['east'],
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
