<?php

namespace App\Skills;

use App\Commands\Woodcutting\Chop;

class Woodcutting extends Skill
{
    protected function chop(): \Illuminate\Http\JsonResponse
    {
        return app(Chop::class)->log();
    }
}
