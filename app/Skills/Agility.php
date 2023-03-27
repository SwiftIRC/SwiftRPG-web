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
            return app(Explore::class)->log($direction);
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

    protected function npcs()
    {
        return app(NPCs::class)->log();
    }

    protected function buildings()
    {
        return app(Buildings::class)->log();
    }

}
