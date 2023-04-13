<?php

namespace App\Skills;

use App\Commands\Woodcutting\Chop;

class Woodcutting extends Skill
{
    protected function chop($input): \Illuminate\Http\Response
    {
        return app(Chop::class)->queue($input);
    }
}
