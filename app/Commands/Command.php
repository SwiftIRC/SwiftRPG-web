<?php

namespace App\Commands;

use App\Http\Response\Reward;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Command
{
    protected $user;
    protected $command;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @param object $input
     *
     * @return void
     */
    public function execute(object $input): void
    {
        $this->user = $input->user()->first();
        $this->command = $input->command;

        $reward = $this->generateReward($this->command);

        $reward->experience->each(function ($skill) {
            $this->user->addXp($skill->id, $skill->pivot->value);
        });
        $reward->loot->each(function ($item) {
            $this->user->addToInventory($item, $item->pivot->value);
        });
    }

    /**
     * @param User $user
     * @param App\Models\Command $command
     *
     * @return Reward
     */
    protected function generateReward($command): Reward
    {
        $skill_rewards = $command->getSkillRewardsWithTotals($this->user);
        $item_rewards = $command->getItemRewardsWithTotals($this->user);

        return new Reward(
            $skill_rewards,
            $item_rewards,
        );
    }

}
