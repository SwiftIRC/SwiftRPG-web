<?php

namespace App\Http\Controllers;

use App\Skills\Thieving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OverflowException;
use RangeException;

class ThievingController extends Controller
{
    public function index()
    {
        return view('thieving.index');
    }

    public function pickpocket(Request $request): \Illuminate\Http\Response
    {
        try {
            return app(Thieving::class)->pickpocket($request);
        } catch (RangeException $e) {
            return response()->error(
                [
                    'error' => $e->getMessage(),
                    'metadata' => [
                        'hitpoints' => $request->user()->damage(0),
                    ],
                ],
                200
            );
        } catch (OverflowException $e) {
            return response()->error(
                [
                    'error' => $e->getMessage(),
                    'metadata' => [
                        'hitpoints' => $request->user()->damage(1),
                    ],
                ],
                200
            );
        }
    }

    public function steal()
    {
        if (Auth::user()->thieving < level_to_xp(10)) {
            return response()->json(['error' => 'You need to be level 10 to steal.'], 200);
        }

        try {
            return app(Thieving::class)->steal();
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    public function pilfer()
    {
        if (Auth::user()->thieving < level_to_xp(20)) {
            return response()->json(['error' => 'You need to be level 20 to pilfer.'], 200);
        }

        try {
            return response()->json(app(Thieving::class)->pilfer());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    public function plunder()
    {
        if (Auth::user()->thieving < level_to_xp(30)) {
            return response()->json(['error' => 'You need to be level 30 to plunder.'], 200);
        }

        try {
            return response()->json(app(Thieving::class)->plunder());
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
