<?php

namespace App\Commands\Thieving;

use App\Commands\Command;
use Illuminate\Support\Facades\Auth;
use OverflowException;
use RangeException;

class Pickpocket extends Command
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
        $tile = $user->tile();
        $npcs = $tile->npcs()->get();
        $command = array_pop($input);

        if (!$npcs->count()) {
            $buildings = $tile->buildings()->get();
            throw new RangeException('You failed to pickpocket because there was nobody around! ' . ($buildings->count() ? 'Check a building?' : ''));
        }

        $npc = $npcs->random();

        $chance_to_fail = random_int(0, xp_to_level($user->thieving) + 1);
        if (!$chance_to_fail) {
            throw new OverflowException('You failed to pickpocket, ' . $npc->first_name . ' ' . $npc->last_name . '!');
        }

        return response()->json([
            'skill' => 'thieving',
            'method' => 'pickpocket',
            'experience' => $user->thieving,
            'reward' => $this->generateReward($user->gold),
            'ticks' => $command->ticks,
            'seconds_until_tick' => seconds_until_tick($command->ticks),
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
