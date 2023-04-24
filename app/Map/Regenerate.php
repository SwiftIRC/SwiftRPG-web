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

        return Tile::where('available_trees', '<', DB::raw('max_trees'))->whereDate('last_disturbed', '<=', now()->subMinutes(5))->whereNotIn('id', $tile_ids)->increment('available_trees');
    }
}
