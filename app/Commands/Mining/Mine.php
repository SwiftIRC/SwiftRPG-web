<?php

namespace App\Commands\Mining;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Mine extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $tile = $this->user->tile()->first();

        $this->command = array_pop($input);

        if ($tile->available_ore < 1) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'There is no ore left on this tile to mine!',
                'ticks' => 0,
                'user' => $this->user,
            ]);
        }

        $tile->available_ore--;
        $tile->save();

        return response()->object(
            [
                'command' => $this->command,
                'reward' => $this->generateReward(),
                'user' => $this->user,
            ]
        );
    }
}
