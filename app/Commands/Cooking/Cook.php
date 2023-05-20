<?php

namespace App\Commands\Cooking;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Cook extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $raw_fish = $this->user->items()->where('name', 'Raw Fish')->withPivot('deleted_at')->first();
        $this->command = array_pop($input);

        if (!isset($raw_fish)) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'There are no raw fish in your inventory to cook!',
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
