<?php

namespace App\Skills;

use App\Commands\Firemaking\Burn;
use RangeException;

class Firemaking extends Skill
{
    protected function burn()
    {
        try {
            return app(Burn::class)->execute();
        } catch (RangeException $e) {
            throw new RangeException($e->getMessage());
        }
    }
}
