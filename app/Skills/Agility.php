<?php

namespace App\Skills;

use App\Commands\Agility\Explore;
use App\Commands\Agility\Look;
use Illuminate\Http\Request;
use RangeException;

class Agility extends Skill
{
    protected function explore(Request $request)
    {
        try {
            return app(Explore::class)->log($request->direction);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    protected function look(array $direction)
    {
        try {
            return app(Look::class)->log($direction);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
