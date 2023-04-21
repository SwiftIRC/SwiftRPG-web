<?php

namespace App\Commands\Thieving;

use App\Commands\Command;
use RangeException;

class Pickpocket extends Command
{
    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $this->command = array_pop($input);
        $request = array_pop($input);
        $this->user = $request->user();
        $tile = $this->user->tile();
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

        // $chance_to_fail = random_int(0, xp_to_level($this->user->thieving) + 1);

        $level_difference = xp_to_level($npc->thieving) - xp_to_level($this->user->thieving);
        $success_rate = max(10, 90 - ($level_difference * 4));
        $random = random_int(0, 100);
        if ($random > $success_rate) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'You failed to pickpocket, ' . $npc->first_name . ' ' . $npc->last_name . '! (Thieving level: ' . xp_to_level($npc->thieving) . ')',
                ]);
        }

        return response()->object(
            [
                'reward' => $this->generateReward($this->user->gold),
                'command' => $this->command,
            ]
        );
    }
}
