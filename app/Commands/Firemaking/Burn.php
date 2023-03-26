<?php

namespace App\Commands\Firemaking;

use App\Commands\Command;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Burn extends Command
{
    protected $quantity = 0;

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

    public function log(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $log = $user->items()->where('name', 'Logs')->withPivot('deleted_at')->first();

        if (!isset($log)) {
            throw new RangeException('There are no logs in your inventory to burn!');
        }

        $logs = $user->numberInInventory($log);

        return response()->json([
            'skill' => 'firemaking',
            'experience' => $user->firemaking,
            'reward' => $this->generateReward($logs),
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [
            'type' => 'logs',
            'quantity' => $this->quantity,
            'total' => $total,
        ];
    }
}
