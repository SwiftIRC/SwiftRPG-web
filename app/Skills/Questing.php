<?php

namespace App\Skills;

use App\Commands\Questing\Start;

class Questing extends Skill
{
    protected function start($input): \Illuminate\Http\JsonResponse
    {
        return app(Start::class)->queue([$input]);
    }
}
