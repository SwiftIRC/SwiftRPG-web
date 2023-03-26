<?php

namespace App\Http\Controllers;

use App\Map\Move;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    public function move(Request $request)
    {
        return app(Move::class)->move($request->user(), $request->direction);
    }

    public function look(Request $request)
    {
        return app(Move::class)->look($request->user());
    }

    public function npcs(Request $request)
    {
        return app(Move::class)->npcs($request->user());
    }

    public function buildings(Request $request)
    {
        return app(Move::class)->buildings($request->user());
    }

    public function lookindirection(Request $request, string $direction)
    {
        if (!in_array($direction, ['north', 'east', 'south', 'west'])) {
            return response()->json(['error' => 'Invalid direction.'], 400);
        }

        return app(Move::class)->look_at($request->user(), $direction);
    }
}
