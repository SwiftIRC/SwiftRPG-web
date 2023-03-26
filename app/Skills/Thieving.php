<?php

namespace App\Skills;

use App\Commands\Thieving\Pickpocket;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Thieving extends Skill
{
    protected function pickpocket(): \Illuminate\Http\JsonResponse
    {
        return app(Pickpocket::class)->execute();
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

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->gold]);
    }

    protected function pilfer()
    {
        $user = Auth::user();
        $user->thieving += 50;
        $user->addGold(50);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->gold]);
    }

    protected function plunder()
    {
        $user = Auth::user();
        $user->thieving += 100;
        $user->addGold(100);
        $user->save();

        return response()->json(['thieving' => $user->thieving, 'gold' => $user->gold]);
    }
}
