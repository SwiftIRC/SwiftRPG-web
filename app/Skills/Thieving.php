<?php

namespace App\Skills;

use App\Commands\Thieving\Pickpocket;
use App\Commands\Thieving\Steal;
use Illuminate\Support\Facades\Auth;
use OverflowException;
use RangeException;

class Thieving extends Skill
{
    protected function pickpocket($input): \Illuminate\Http\JsonResponse
    {
        try {
            return app(Pickpocket::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        } catch (OverflowException $e) {
            return response()->json(['error' => $e->getMessage(), 'hitpoints' => Auth::user()->damage(1)], 200);
        }
    }

    protected function steal(): \Illuminate\Http\JsonResponse
    {
        try {
            return app(Steal::class)->queue();
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        } catch (OverflowException $e) {
            return response()->json(['error' => $e->getMessage(), 'hitpoints' => Auth::user()->damage(2)], 200);
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
