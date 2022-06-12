<?php

namespace App\Skills;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\CommandLog;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Thieving extends Skill
{
    protected function pickpocket()
    {
        $user = Auth::user();
        $user->thieving += 5;
        $user->save();
        $user->inventory->gold += 5;
        $user->inventory->save();

        return ['thieving' => $user->thieving, 'gold' => $user->inventory->gold];
    }
}
