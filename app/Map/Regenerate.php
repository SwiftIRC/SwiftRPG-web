<?php

namespace App\Map;

use App\Models\Tile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Regenerate
{
    public function map()
    {
        $tile_ids = User::all()->pluck('tile_id')->unique();

        Tile::where('available_trees', '<', DB::raw('max_trees'))->whereDate('last_disturbed', '<=', now()->subMinutes(5))->whereNotIn('id', $tile_ids)->increment('available_trees');

        Tile::where('available_ore', '<', DB::raw('max_ore'))->whereDate('last_disturbed', '<=', now()->subMinutes(5))->whereNotIn('id', $tile_ids)->increment('available_ore');

        return 0;
    }
}
