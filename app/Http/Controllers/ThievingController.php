<?php

namespace App\Http\Controllers;

use RangeException;
use App\Skills\Thieving;
use App\Models\Inventory;
use App\Models\CommandLog;
use Brick\Math\Exception\MathException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThievingController extends Controller
{
    public function index()
    {
        return view('thieving.index');
    }

    public function pickpocket()
    {
        $user = Auth::user();
        try {
            return response()->json(app(Thieving::class)->pickpocket($user));
        } catch (MathException $e) {
            return response()->json(['error' => $e->getMessage(), 'hitpoints' => $user->hitpoints], 200);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function steal()
    {
        if (Auth::user()->thieving < level_to_xp(10)) {
            return response()->json(['error' => 'You need to be level 10 to steal.'], 403);
        }

        try {
            return response()->json(app(Thieving::class)->steal());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function pilfer()
    {
        if (Auth::user()->thieving < level_to_xp(20)) {
            return response()->json(['error' => 'You need to be level 20 to pilfer.'], 403);
        }

        try {
            return response()->json(app(Thieving::class)->pilfer());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function plunder()
    {
        if (Auth::user()->thieving < level_to_xp(30)) {
            return response()->json(['error' => 'You need to be level 30 to plunder.'], 403);
        }

        try {
            return response()->json(app(Thieving::class)->plunder());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
