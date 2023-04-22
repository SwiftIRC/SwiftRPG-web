<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Look extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();

        $this->command = array_pop($input);
        $direction = array_pop($input);

        if (in_array($direction, ['north', 'south', 'east', 'west'])) {
            $tile = app(Move::class)->look_at($this->user, $direction);
        } else {
            $tile = app(Move::class)->look($this->user);
        }

        $tile->direction = $direction;
        $tile->discovered_by = User::find($tile->discovered_by);

        return response()->object([
            'command' => $this->command,
            'metadata' => $tile,
            'reward' => $this->generateReward(),
        ]);
    }
}
