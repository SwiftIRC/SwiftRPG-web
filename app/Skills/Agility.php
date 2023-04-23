<?php

namespace App\Skills;

use App\Commands\Agility\Buildings;
use App\Commands\Agility\Explore;
use App\Commands\Agility\Look;
use App\Commands\Agility\NPCs;

class Agility extends Skill
{
    protected function explore($input)
    {
        return app(Explore::class)->queue($input);
    }

    protected function look($input)
    {
        return app(Look::class)->queue($input);
    }

    protected function npcs(array $input)
    {
        return app(NPCs::class)->queue($input);
    }

    protected function buildings(array $input)
    {
        return app(Buildings::class)->queue($input);
    }

}
