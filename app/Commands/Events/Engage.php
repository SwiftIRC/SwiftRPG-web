<?php

namespace App\Commands\Events;

use App\Commands\Command;
use Illuminate\Support\Facades\Auth;

class Engage extends Command
{
    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $this->user = Auth::user();

        // $event = Event::withTrashed()->firstWhere('deleted_at', '>', now());
        // if (empty($event)) {
        //     return response()->object(['failure' => 'No active event.', 'ticks' => 0], 400);
        // }

        // $event->reward->skills()->syncWithoutDetaching($request->skills);
        // $event->reward->items()->syncWithoutDetaching($request->items);

        // return response()->json(['success' => 'Event completed.']);

        return response()->object([
            'reward' => $this->generateReward(),
            'ticks' => $this->command->ticks,
        ]);
    }
}
