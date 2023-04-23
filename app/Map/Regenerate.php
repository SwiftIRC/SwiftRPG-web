<?php

namespace App\Map;

use App\Models\Tile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Regenerate
{
    public function map()
    {
        $tiles = Tile::where('available_trees', '<', 'max_trees')->where('last_disturbed', '<', DB::raw('CURRENT_TIMESTAMP'))->get();

        $toggled = false;

        foreach ($tiles as $tile) {
            if ($this->tile($tile)) {
                $toggled = true;
            }
        }
        return $toggled;
    }

    public function tile(Tile $tile)
    {
        $players = User::where('tile_id', $tile->id)->get();

        if (!$players->count()) {
            $tile->available_trees++;
            $tile->save();

            return true;
        }

        return false;
    }
}
