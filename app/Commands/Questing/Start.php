<?php

namespace App\Commands\Questing;

use App\Commands\Command;
use App\Models\Quest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Start extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();

        $increment = $this->quantity;

        $user->thieving += $increment;
        $user->addGold($increment);
        $user->save();

        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $command = array_pop($input);

        Log::info($input);

        $request = array_pop($input);

        Log::info($request);
        $step_id = array_pop($request->step_id);
        $quest_id = array_pop($request->quest_id);

        $response = app(Quest::class)->start($quest_id, $step_id ?? 1);

        Log::info($response);

        return response()->json([
            'skill' => 'questing',
            'method' => 'start',
            'experience' => 0,
            'reward' => $this->generateReward(),
            'ticks' => 0,
            'seconds_until_tick' => 0,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [
            'type' => 'gold',
            'quantity' => $this->quantity,
            'total' => $total,
        ];
    }
}
