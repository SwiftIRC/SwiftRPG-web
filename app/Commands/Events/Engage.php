<?php

namespace App\Commands\Events;

use App\Commands\Command;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Engage extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $this->command = array_pop($input);

        $event = Event::withTrashed()->firstWhere('deleted_at', '>', now());
        if (empty($event)) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'No active event.',
                    'ticks' => 0,
                ],
                400
            );
        }

        return response()->object([
            'command' => $this->command,
            'reward' => $this->generateReward(),
            'ticks' => $this->command->ticks,
        ]);
    }
}
