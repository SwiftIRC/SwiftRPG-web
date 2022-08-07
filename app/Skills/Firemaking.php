<?php

namespace App\Skills;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\CommandLog;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Firemaking extends Skill
{
    protected function burn()
    {
        $user = Auth::user();
        $inventory = $user->inventory()->first();
        if ($inventory) {
            $log = $inventory->items()->where('name', 'Logs')->first();
        }

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        $log->delete();

        $user->firemaking += 5;
        $user->save();

        $logs = $inventory->items()->where('name', 'Logs')->count();

        return response()->json(['firemaking' => $user->firemaking, 'logs' => $logs]);
    }
}
