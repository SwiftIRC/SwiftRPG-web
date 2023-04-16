<?php

namespace App\Skills;

use App\Commands\Agility\Buildings;
use App\Commands\Agility\Explore;
use App\Commands\Agility\Look;
use App\Commands\Agility\NPCs;
use RangeException;

class Agility extends Skill
{
    protected function explore(array $direction)
    {
        try {
            return app(Explore::class)->queue($direction);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    protected function look(array $direction)
    {
        try {
            return app(Look::class)->queue($direction);
        } catch (RangeException $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    protected function npcs(array $input)
    {
        return app(NPCs::class)->queue($input);
    }

    protected function buildings()
    {
        return app(Buildings::class)->queue();
    }

}
