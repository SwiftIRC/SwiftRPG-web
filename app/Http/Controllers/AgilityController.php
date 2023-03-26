<?php

namespace App\Http\Controllers;

use App\Skills\Agility;
use Illuminate\Http\Request;
use RangeException;

class AgilityController extends Controller
{
    public function explore(Request $request)
    {
        try {
            return app(Agility::class)->explore($request->direction);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function look(Request $request)
    {
        try {
            return app(Agility::class)->look([$request->direction]);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function npcs(Request $request)
    {
        return app(Agility::class)->npcs($request->user());
    }

    public function buildings(Request $request)
    {
        return app(Agility::class)->buildings($request->user());
    }

    public function lookInDirection(Request $request, string $direction)
    {
        if (!in_array($direction, ['north', 'east', 'south', 'west'])) {
            return response()->json(['error' => 'Invalid direction.'], 400);
        }

        return app(Agility::class)->look([$direction]);
    }
}
