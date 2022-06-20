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
        $tile = $user->tile();
        $npcs = $tile->npcs();
        $buildings = $tile->buildings();

        if (!$npcs->count()) {
            throw new RangeException('There are no NPCs on this tile to pickpocket! ' . ($buildings->count() ? 'Check a building?' : ''));
        }

        $user->thieving += 5;
        $user->addGold(5);
        $user->save();

        return ['thieving' => $user->thieving, 'gold' => $user->getGold()];
    }

    protected function steal()
    {
        $user = Auth::user();
        $building = $user->building();

        if (!$building) {
            throw new RangeException('You are not in a building from which to steal!');
        }

        $user->thieving += 10;
        $user->addGold(10);
        $user->save();

        return ['thieving' => $user->thieving, 'gold' => $user->getGold()];
    }

    protected function pilfer()
    {
        $user = Auth::user();
        $user->thieving += 50;
        $user->addGold(50);
        $user->save();

        return ['thieving' => $user->thieving, 'gold' => $user->getGold()];
    }

    protected function plunder()
    {
        $user = Auth::user();
        $user->thieving += 100;
        $user->addGold(100);
        $user->save();

        return ['thieving' => $user->thieving, 'gold' => $user->getGold()];
    }
}
