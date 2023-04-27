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
            $this->user->addXp($skill->id, $skill->pivot->quantity);
        });
        $reward->loot->each(function ($item) {
            $amount = $item->pivot->quantity;
            if ($amount < 1) {
                $this->user->removeFromInventory($item, abs($amount));
            } else {
                $this->user->addToInventory($item, $amount);
            }
        });

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
        $skills = $this->command->getSkillRewardsWithTotals($this->user);
        $items = $this->command->getItemRewardsWithTotals($this->user);

        return new Reward(
            $experience = $skills,
            $loot = $items,
        );
    }

}
