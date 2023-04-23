<?php

namespace App\Commands;

use App\Http\Response\Reward;
use App\Models\Client;
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
            $skill = $skill->toArray();
            $this->user->addXp($skill['details']['id'], $skill['gained']);
        });
        $reward->loot->each(function ($item) {
            $array = $item->toArray();
            $amount = $array['gained'];
            if ($amount < 1) {
                $this->user->removeFromInventory($item->item, abs($amount));
            } else {
                $this->user->addToInventory($item->item, $amount);
            }
        });

        // this relation is not desirable to send to the client
        unset($this->command->reward);

        $client = Client::firstWhere('id', $input->client_id);
        $response = response()->object([
            'command' => $this->command,
            'webhook_id' => $input->id,
            'reward' => $reward,
            'user' => $this->user,
        ]);

        post_webhook_endpoint($client->endpoint, [
            'type' => 'command_complete',
            'data' => $response->original,
        ]);
    }

    /**
     *
     * @return Reward
     */
    protected function generateReward(): Reward
    {
        $skill_rewards = collect();
        $item_rewards = collect();

        $skills = $this->command->getSkillRewardsWithTotals($this->user);
        if ($skills != null) {
            foreach ($skills as $skill) {
                $skill_rewards->push($skill->acquire($this->user));
            }
        }

        $items = $this->command->getItemRewardsWithTotals($this->user);
        if ($items != null) {
            foreach ($items as $item) {
                $item_rewards->push($item->acquire($this->user));
            }
        }

        return new Reward(
            $skill_rewards,
            $item_rewards,
        );
    }

}
