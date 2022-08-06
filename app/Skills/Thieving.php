<?php

namespace App\Skills;

use RangeException;
use App\Models\Item;
use App\Models\User;
use App\Models\Inventory;
use App\Models\CommandLog;
use Illuminate\Support\Facades\Auth;
use Brick\Math\Exception\MathException;

class Thieving extends Skill
{
    protected function pickpocket(array $parameters)
    {
        $user = $parameters[0];
        $tile = $user->tile();
        $npcs = $tile->npcs();

        if (!$npcs->count()) {
            $buildings = $tile->buildings()->get();
            throw new RangeException('There are no NPCs on this tile to pickpocket! ' . ($buildings->count() ? 'Check a building?' : ''));
        }

        $npc = $npcs->get()->random();

        $chance_to_fail = random_int(0, xp_to_level($user->thieving) + 1);
        if (!$chance_to_fail) {
            throw new MathException('You failed to pickpocket, ' . $npc->name . '!');
        }

        $increment = 5;

        $user->thieving += $increment;
        $user->addGold($increment);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->getGold()]);
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
