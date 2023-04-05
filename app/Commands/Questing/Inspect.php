<?php

namespace App\Commands\Questing;

use App\Commands\Command;
use App\Models\Quest;
use Illuminate\Support\Facades\Auth;

class Inspect extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $command = array_pop($input);
        $quest_id = array_pop($input);

        $response = app(Quest::class)->inspect($quest_id);

        return response()->json([
            'skill' => 'questing',
            'method' => 'inspect',
            'experience' => 0,
            'reward' => $this->generateReward(),
            'meta' => compact('response'),
            'ticks' => $command->ticks + $response->step->ticks,
            'seconds_until_tick' => 0,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
