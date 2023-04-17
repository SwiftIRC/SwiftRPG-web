<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Buildings extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $this->command = array_pop($input);

        $buildings = app(Move::class)->buildings($this->user);

        return response()->object([
            'reward' => $this->generateReward(),
            'metadata' => $buildings,
        ]);
    }
}
