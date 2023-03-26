<?php

namespace App\Commands\Woodcutting;

use App\Commands\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class Chop extends Command
{
    protected $quantity = 5;

    public function execute(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $tile = $user->tile();

        if ($tile->available_trees < 1) {
            throw new RangeException('There are no trees left on this tile to chop!');
        }

        $tile->available_trees--;
        $tile->save();

        $user->woodcutting += 5;
        $user->save();

        $item = Item::where('name', 'Logs')->first();
        $logs = $user->addToInventory($item);

        return response()->json([
            'skill' => 'woodcutting',
            'experience' => $user->woodcutting,
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
