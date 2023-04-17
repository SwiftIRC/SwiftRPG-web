<?php

namespace App\Commands\Firemaking;

use App\Commands\Command;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Burn extends Command
{
    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $this->user = Auth::user();
        $log = $this->user->items()->where('name', 'Logs')->withPivot('deleted_at')->first();
        $this->command = array_pop($input);

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        return response()->object([
            'reward' => $this->generateReward(),
            'ticks' => $this->command->ticks,
        ]);
    }
}
