<?php

namespace App\Commands\Woodcutting;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Chop extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $tile = $this->user->tile();

        $this->command = array_pop($input);

        if ($tile->available_trees < 1) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'There are no trees left on this tile to chop!',
                'ticks' => 0,
                'user' => $this->user,
            ]);
        }

        $tile->available_trees--;
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
