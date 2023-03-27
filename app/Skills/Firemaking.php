<?php

namespace App\Skills;

use App\Commands\Firemaking\Burn;
use RangeException;

class Firemaking extends Skill
{
    protected function burn($input)
    {
        try {
            return app(Burn::class)->log($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
