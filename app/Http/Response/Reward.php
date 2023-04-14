<?php

namespace App\Http\Response;

use App\Http\Response\Loot;

class Reward
{
    public $loot;
    public $experience;

    public function __construct(int $experience = 0, array $loot = [])
    {
        foreach ($loot as $item) {
            $this->loot[] = new Loot($item['name'], $item['quantity'], $item['total']);
        }

        $this->experience = $experience;
    }
}
