<?php

namespace App\Skills;

use RangeException;
use App\Models\ItemUser;
use Illuminate\Support\Facades\Auth;

class Firemaking extends Skill
{
    protected function burn()
    {
        $user = Auth::user();
        $log = $user->items()->where('name', 'Logs')->withPivot('deleted_at')->first();

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        $user->removeFromInventory($log);

        $user->firemaking += 5;
        $user->save();

        $logs = $user->items()->where('name', 'Logs')->count();

        return response()->json(['firemaking' => $user->firemaking, 'logs' => $logs]);
    }
}
