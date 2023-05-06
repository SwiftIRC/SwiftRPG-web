<?php

namespace App\Commands\Questing;

use App\Commands\Command;
use App\Http\Response\Quest as ResponseQuest;
use App\Http\Response\Reward;
use App\Models\Client;
use App\Models\Quest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Start extends Command
{
    protected $quest;

    public function execute(object $input): void
    {
        $this->user = $input->user()->first();
        $this->command = $input->command;
        $json = json_decode($input->metadata);
        $quest = Collection::make([$json])->first();
        $this->quest = Quest::with('steps')->firstWhere('id', $quest->details->id);

        if (count($quest->incomplete_steps) == 1 && $quest->incomplete_steps[0]->id == $quest->step_details->id) {
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
        }

        $client = Client::firstWhere('id', $input->client_id);
        $response = response()->object([
            'command' => $this->command,
            'webhook_id' => $input->id,
            'reward' => $this->generateReward(),
            'user' => $this->user,
        ]);

        post_webhook_endpoint($client->endpoint, [
            'type' => 'command_complete',
            'data' => $response->original,
        ]);
    }

    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();

        $this->command = array_pop($input);
        $request = array_pop($input);

        $step_id = $request->step_id ?? 1;
        if ($step_id < 1) {
            $step_id = 1;
        }
        $quest_id = $request->quest_id;

        $this->quest = Quest::with('steps')->firstWhere('id', $quest_id);

        if ($this->quest == null) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'This quest does not exist!',
                'ticks' => 0,
                'user' => $this->user,
            ]);
        } elseif ($step_id > $this->quest->steps->count()) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'This quest does not have that many steps!',
                'ticks' => 0,
                'user' => $this->user,
            ]);
        }

        $ticks = $this->quest->steps[$step_id - 1]->ticks;

        $response = app(Quest::class)->start($quest_id, $step_id);

        if ($response->completeStep != null) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'You have already completed this step of the quest!',
                'ticks' => 0,
                'user' => $this->user,
            ]);
        } elseif ($response->incompleteDependencies > 0) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'You have not completed the required steps to start this quest!',
                'metadata' => [

                ],
                'ticks' => 0,
                'user' => $this->user,
            ]);
        }

        return response()->object([
            'command' => $this->command,
            'reward' => $this->generateReward(),
            'user' => $this->user,
            'metadata' => (new ResponseQuest($response))->toArray(),
            'ticks' => $ticks,
        ]);
    }

    protected function generateReward($total = 0): Reward
    {
        $skills = $this->quest->getSkillRewardsWithTotals($this->user);
        $items = $this->quest->getItemRewardsWithTotals($this->user);

        return new Reward(
            $experience = $skills,
            $loot = $items,
        );
    }
}
