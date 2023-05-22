<?php

namespace App\Skills;

use App\Commands\Mining\Mine;
use RangeException;

class Mining extends Skill
{
    protected function mine($input)
    {
        try {
            return app(Mine::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
