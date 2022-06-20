<?php

namespace App\Map;

use App\Models\Tile;

class Regenerate
{
    public function map()
    {
        $tiles = Tile::where('max_trees', '>', 0)->where('last_disturbed', '<', 'NOW() - 300')->get();

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
        $players = $tile->users();

        if (!$players->count()) {
            $tile->available_trees = $tile->max_trees;
            return true;
        }
        return false;
    }
}
