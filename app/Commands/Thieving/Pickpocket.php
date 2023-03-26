<?php

namespace App\Commands\Thieving;

use App\Commands\Command;
use Illuminate\Support\Facades\Auth;

class Pickpocket extends Command
{
    protected $quantity = 5;

    public function execute(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $tile = $user->tile();
        $npcs = $tile->npcs();

        if (!$npcs->count()) {
            $buildings = $tile->buildings()->get();
            throw new RangeException('There are no NPCs on this tile to pickpocket! ' . ($buildings->count() ? 'Check a building?' : ''));
        }

        $npc = $npcs->get()->random();

        $chance_to_fail = random_int(0, xp_to_level($user->thieving) + 1);
        if (!$chance_to_fail) {
            throw new MathException('You failed to pickpocket, ' . $npc->name . '!');
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
