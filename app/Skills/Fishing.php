<?php

namespace App\Skills;

use App\Commands\Fishing\Fish;
use RangeException;

class Fishing extends Skill
{
    protected function fish($input)
    {
        try {
            return app(Fish::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
