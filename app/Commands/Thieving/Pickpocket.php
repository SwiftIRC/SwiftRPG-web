<?php

namespace App\Commands\Thieving;

use App\Commands\Command2;
use OverflowException;
use RangeException;

class Pickpocket extends Command2
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

    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $command = array_pop($input);
        $request = array_pop($input);
        $user = $request->user();
        $tile = $user->tile();
        $npcs = $tile->npcs()->get();

        if (!$npcs->count()) {
            $buildings = $tile->buildings()->get();
            throw new RangeException('You failed to pickpocket because there was nobody around! ' . ($buildings->count() ? 'Check a building?' : ''));
        }

        $npc = $npcs->random();
        if ($request->input('target') && is_numeric($request->input('target'))) {
            $target = ((int) $request->input('target')) - 1;
            $npc = $npcs->splice($target, 1)->first();
        }

        // $chance_to_fail = random_int(0, xp_to_level($user->thieving) + 1);

        $level_difference = xp_to_level($npc->thieving) - xp_to_level($user->thieving);
        $success_rate = max(10, 90 - ($level_difference * 4));
        $random = random_int(0, 100);
        if ($random > $success_rate) {
            throw new OverflowException('You failed to pickpocket, ' . $npc->first_name . ' ' . $npc->last_name . '! (Thieving level: ' . xp_to_level($npc->thieving) . ')');
        }

        return response()->object(
            [
                'skill' => 'thieving',
                'method' => 'pickpocket',
                'experience' => $user->thieving,
                'reward' => $this->generateReward($user->gold),
                'ticks' => $command->ticks,
            ]
        );
    }

    protected function generateReward($total = 0): array
    {
        return [
            'loot' => [
                [
                    'name' => 'gold',
                    'quantity' => $this->quantity,
                    'total' => $total,
                ],
            ],
            'experience' => $this->quantity,
        ];
    }
}
