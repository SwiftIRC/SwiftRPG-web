<?php

namespace App\Commands\Questing;

use App\Commands\Command;
use App\Models\Quest;
use Illuminate\Support\Facades\Auth;

class Start extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();
        $quest = Quest::find($input->quest_id);

        $increment = $this->quantity;

        $skills = get_skills();

        $skills->each(function ($skill) use ($user, $quest) {
            $user->{$skill} += $quest->{$skill};
        });

        $user->addGold($quest->gold);
        $user->save();

        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $command = array_pop($input);
        $request = array_pop($input);

        $step_id = $request->step_id;
        $quest_id = $request->quest_id;

        $response = app(Quest::class)->start($quest_id, $step_id ?? 1);

        return response()->json([
            'skill' => 'questing',
            'method' => 'start',
            'experience' => 0,
            'reward' => $this->generateReward(),
            'metadata' => compact('response'),
            'ticks' => $command->ticks + $response->step->ticks,
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
