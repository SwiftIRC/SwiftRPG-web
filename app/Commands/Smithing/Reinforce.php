<?php

namespace App\Commands\Smithing;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Reinforce extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $sword = $this->user->items()->where('name', 'Iron Sword')->withPivot('deleted_at')->first();
        $this->command = array_pop($input);

        if (!$sword || $sword->count() < 2) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'There need two iron swords in your inventory to reinforce them!',
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
