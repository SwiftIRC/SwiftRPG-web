<?php

namespace App\Commands\Thieving;

use App\Commands\Command;
use Illuminate\Support\Facades\Auth;

class Steal extends Command
{
    protected $quantity = 10;

    public function execute(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $building = $user->building();

        if (!$building) {
            throw new RangeException('You are not in a building from which to steal!');
        }

        $increment = $this->quantity;

        $user->thieving += $increment;
        $user->addGold($increment);
        $user->save();

        return response()->json([
            'skill' => 'thieving',
            'experience' => $user->thieving,
            'reward' => $this->generateReward($user->gold),
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
