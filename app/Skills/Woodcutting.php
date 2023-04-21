<?php

namespace App\Skills;

use App\Commands\Woodcutting\Chop;
use Illuminate\Http\Response;

class Woodcutting extends Skill
{
    protected function chop($input): Response
    {
        return app(Chop::class)->queue($input);
    }
}
