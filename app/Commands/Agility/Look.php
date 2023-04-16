<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Look extends Command
{
    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $user = Auth::user();

        $command = array_pop($input);
        $direction = array_pop($input);

        if (in_array($direction, ['north', 'south', 'east', 'west'])) {
            $tile = app(Move::class)->look_at($user, $direction);
        } else {
            $tile = app(Move::class)->look($user);
        }

        $tile->direction = $direction;
        $tile->discovered_by = User::find($tile->discovered_by);

        return response()->object([
            'reward' => $this->generateReward($user, $command),
            'metadata' => $tile,
            'ticks' => 0,
        ]);
    }
}
