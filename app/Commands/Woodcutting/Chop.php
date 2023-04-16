<?php

namespace App\Commands\Woodcutting;

use App\Commands\Command3;
use App\Http\Response\Reward;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Chop extends Command3
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();
        $command = $input->command;

        $reward = $this->generateReward($user, $command);

        $reward->experience->each(function ($skill) use ($user) {
            $user->addXp($skill->id, $skill->pivot->value);
        });
        $reward->loot->each(function ($item) use ($user) {
            $user->addToInventory($item, $item->pivot->value);
        });

        return response()->json([
            'skill' => 'woodcutting',
            'experience' => $user->woodcutting,
            'reward_xp' => $this->quantity,
            'reward' => $reward,
            'execute' => true,
        ]);
    }

    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $user = Auth::user();
        $tile = $user->tile();

        $command = array_pop($input);

        if ($tile->available_trees < 1) {
            throw new RangeException('There are no trees left on this tile to chop!');
        }

        $tile->available_trees--;
        $tile->save();

        return response()->object(
            [
                'skill' => 'woodcutting',
                'experience' => $user->woodcutting,
                'reward' => $this->generateReward($user, $command),
                'ticks' => $command->ticks,
            ]
        );
    }

    /**
     * @param User $user
     * @param Command $command
     *
     * @return Reward
     */
    protected function generateReward($user, $command): Reward
    {
        $skill_rewards = $command->getSkillRewardsWithTotals($user);
        $item_rewards = $command->getItemRewardsWithTotals($user);

        return new Reward(
            $skill_rewards,
            $item_rewards,
        );
    }
}
