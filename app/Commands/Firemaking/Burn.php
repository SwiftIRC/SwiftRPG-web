<?php

namespace App\Commands\Firemaking;

use App\Commands\Command2;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Burn extends Command2
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();
        $log = $user->items()->where('name', 'Logs')->withPivot('deleted_at')->first();

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        $user->removeFromInventory($log);

        $user->firemaking += 5;
        $user->save();

        $logs = $user->items()->where('name', 'Logs')->count();

        return response()->json([
            'skill' => 'firemaking',
            'experience' => $user->firemaking,
            'reward' => $this->generateReward($logs),
        ]);
    }

    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $user = Auth::user();
        $log = $user->items()->where('name', 'Logs')->withPivot('deleted_at')->first();
        $command = array_pop($input);

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        $logs = $user->numberInInventory($log);

        return response()->object([
            'skill' => 'firemaking',
            'experience' => $user->firemaking,
            'reward' => $this->generateReward($logs),
            'ticks' => $command->ticks,
            'seconds_until_tick' => seconds_until_tick($command->ticks),
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [
            'loot' => [
                [
                    'name' => 'Logs',
                    'quantity' => -1,
                    'total' => $total,
                ],
            ],
            'experience' => $this->quantity,
        ];
    }
}
