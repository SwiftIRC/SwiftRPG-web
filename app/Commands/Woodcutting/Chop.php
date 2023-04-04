<?php

namespace App\Commands\Woodcutting;

use App\Commands\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Chop extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();
        $tile = $user->tile();

        $user->woodcutting += $this->quantity;
        $user->save();

        $item = Item::where('name', 'Logs')->first();
        $logs = $user->addToInventory($item, $this->quantity);

        return response()->json([
            'skill' => 'woodcutting',
            'experience' => $user->woodcutting,
            'reward_xp' => $this->quantity,
            'reward' => $this->generateReward($logs),
            'execute' => true,
        ]);
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $tile = $user->tile();

        $command = array_pop($input);

        if ($tile->available_trees < 1) {
            throw new RangeException('There are no trees left on this tile to chop!');
        }

        $tile->available_trees--;
        $tile->save();

        $item = Item::where('name', 'Logs')->first();
        $logs = $user->numberInInventory($item);

        return response()->json([
            'skill' => 'woodcutting',
            'experience' => $user->woodcutting,
            'reward_xp' => $this->quantity,
            'reward' => $this->generateReward($logs),
            'ticks' => $command->ticks,
            'seconds_until_tick' => seconds_until_tick($command->ticks),
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
