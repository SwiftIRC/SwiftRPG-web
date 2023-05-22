<?php

namespace App\Commands\Smithing;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Smelt extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $ore = $this->user->items()->where('name', 'Iron Ore')->withPivot('deleted_at')->first();
        $this->command = array_pop($input);

        if (!isset($ore)) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'There is no iron ore in your inventory to smelt!',
                    'ticks' => 0,
                ]
            );
        }

        return response()->object([
            'command' => $this->command,
            'reward' => $this->generateReward(),
            'user' => $this->user,
        ]);
    }
}
