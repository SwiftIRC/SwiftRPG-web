<?php

namespace App\Skills;

use App\Commands\Smithing\Reinforce;
use App\Commands\Smithing\Smelt;
use App\Commands\Smithing\Smith;
use RangeException;

class Smithing extends Skill
{
    protected function reinforce($input)
    {
        try {
            return app(Reinforce::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    protected function smelt($input)
    {
        try {
            return app(Smelt::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    protected function smith($input)
    {
        try {
            return app(Smith::class)->queue($input);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }
}
