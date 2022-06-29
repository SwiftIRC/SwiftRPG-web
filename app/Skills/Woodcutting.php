<?php

namespace App\Skills;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\CommandLog;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Woodcutting extends Skill
{
    protected function chop()
    {
        $user = Auth::user();
        $tile = $user->tile();

        if ($tile->available_trees < 1) {
            throw new RangeException('There are no trees left on this tile to chop!');
        }

        $tile->available_trees--;
        $tile->save();

        $user->woodcutting += 5;
        $user->save();

        $item = Item::where('name', 'Logs')->first();
        $logs = $user->addToInventory($item);

        return ['woodcutting' => $user->woodcutting, 'logs' => $logs];
    }
}
