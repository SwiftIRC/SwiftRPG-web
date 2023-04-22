<?php

namespace App\Commands\Firemaking;

use App\Commands\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Burn extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $log = $this->user->items()->where('name', 'Logs')->withPivot('deleted_at')->first();
        $this->command = array_pop($input);

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        return response()->object([
            'command' => $this->command,
            'reward' => $this->generateReward(),
            'user' => $this->user,
        ]);
    }
}
