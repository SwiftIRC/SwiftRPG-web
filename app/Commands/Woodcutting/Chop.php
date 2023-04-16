<?php

namespace App\Commands\Woodcutting;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Chop extends Command
{
    public function queue(array $input = []): Response
    {
        $user = Auth::user();
        $tile = $user->tile();

        $command = array_pop($input);

        if ($tile->available_trees < 1) {
            throw new RangeException('There are no trees left on this tile to chop!');
        }

        $tile->available_trees--;
        $tile->save();

        return response()->object(
            [
                'reward' => $this->generateReward($command),
                'ticks' => $command->ticks,
            ]
        );
    }

}
