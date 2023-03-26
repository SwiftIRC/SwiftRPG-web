<?php

namespace App\Skills;

use App\Commands\Thieving\Pickpocket;
use App\Commands\Thieving\Steal;
use Illuminate\Support\Facades\Auth;

class Thieving extends Skill
{
    protected function pickpocket(): \Illuminate\Http\JsonResponse
    {
        return app(Pickpocket::class)->execute();
    }

    protected function steal(): \Illuminate\Http\JsonResponse
    {
        return app(Steal::class)->execute();
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
