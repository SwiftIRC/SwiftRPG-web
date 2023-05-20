<?php

namespace App\Skills;

use App\Commands\Cooking\Cook;
use RangeException;

class Cooking extends Skill
{
    protected function cook($input)
    {
        try {
            return app(Cook::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
