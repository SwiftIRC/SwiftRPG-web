<?php

namespace App\Http\Controllers;

use RangeException;
use App\Skills\Thieving;
use Illuminate\Support\Facades\Auth;
use Brick\Math\Exception\MathException;

class ThievingController extends Controller
{
    public function index()
    {
        return view('thieving.index');
    }

    public function pickpocket()
    {
        try {
            return response()->json(app(Thieving::class)->pickpocket());
        } catch (MathException $e) {
            return response()->json(['error' => $e->getMessage(), 'hitpoints' => Auth::user()->damage(1)], 200);
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
