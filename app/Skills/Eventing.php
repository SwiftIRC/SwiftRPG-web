<?php

namespace App\Skills;

use App\Commands\Events\Engage;
use Illuminate\Http\Response;

class Eventing extends Skill
{
    protected function engage($input): Response
    {
        return app(Engage::class)->queue($input);
    }
}
