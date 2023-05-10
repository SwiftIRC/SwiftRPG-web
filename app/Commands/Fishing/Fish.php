<?php

namespace App\Commands\Fishing;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Fish extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $this->command = array_pop($input);

        $water_edge = $this->user->tile->edges()->where('name', 'Water')->first();

        Log::debug('water_edge', [$water_edge]);
        if (is_null($water_edge)) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'There is no adjacent water tile!',
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
