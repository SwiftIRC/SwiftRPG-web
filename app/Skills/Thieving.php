<?php

namespace App\Skills;

use App\Commands\Thieving\Pickpocket;
use App\Commands\Thieving\Steal;
use Illuminate\Support\Facades\Auth;
use OverflowException;
use RangeException;

class Thieving extends Skill
{
    protected function pickpocket(): \Illuminate\Http\JsonResponse
    {
        try {
            return app(Pickpocket::class)->execute();
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        } catch (OverflowException $e) {
            return response()->json(['error' => $e->getMessage(), 'hitpoints' => Auth::user()->damage(1)], 200);
        }
    }

    protected function steal(): \Illuminate\Http\JsonResponse
    {
        try {
            return app(Steal::class)->execute();
        } catch (OverflowException $e) {
            return response()->json(['error' => $e->getMessage(), 'hitpoints' => Auth::user()->damage(1)], 200);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
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
