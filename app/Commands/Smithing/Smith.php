<?php

namespace App\Commands\Smithing;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Smith extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $bar = $this->user->items()->where('name', 'Iron Bar')->withPivot('deleted_at')->first();
        $this->command = array_pop($input);

        if (!$bar) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'There is no iron bar in your inventory to smith!',
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
