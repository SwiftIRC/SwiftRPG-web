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

        $reward = $this->generateReward();

        $reward->experience->each(function ($skill) {
            $this->user->addXp($skill->id, $skill->pivot->value);
        });
        $reward->loot->each(function ($item) {
            $amount = $item->pivot->value;
            if ($amount < 1) {
                $this->user->removeFromInventory($item, abs($amount));
            } else {
                $this->user->addToInventory($item, $amount);
            }
        });

        // TODO webhook followup
    }

    /**
     *
     * @return Reward
     */
    protected function generateReward(): Reward
    {
        $skill_rewards = $this->command->getSkillRewardsWithTotals($this->user);
        $item_rewards = $this->command->getItemRewardsWithTotals($this->user);

        return new Reward(
            $skill_rewards,
            $item_rewards,
        );
    }

}
