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
        $user->addGold(5);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->getGold()]);
    }

    protected function steal()
    {
        $user = Auth::user();
        $user->thieving += 10;
        $user->addGold(10);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->getGold()]);
    }

    protected function pilfer()
    {
        $user = Auth::user();
        $user->thieving += 50;
        $user->addGold(50);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->getGold()]);
    }

    protected function plunder()
    {
        $user = Auth::user();
        $user->thieving += 100;
        $user->addGold(100);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->getGold()]);
    }
}
