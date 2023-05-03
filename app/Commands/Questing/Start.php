<?php

namespace App\Commands\Questing;

use App\Commands\Command;
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

        if (count($quest->incomplete_steps) == 1 && $quest->incomplete_steps[0]->id == $quest->details->step_id) {
            $skills = get_skills();

            $skills->each(function ($skill) use ($quest) {
                $this->user->{$skill} += $quest->{$skill};
            });

            $this->user->addGold($quest->gold);
            $this->user->save();
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
        $quest_id = $request->quest_id;

        $this->quest = Quest::with('steps')->firstWhere('id', $quest_id);

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
                    'incomplete_dependencies' => $response->incompleteDependencies,
                ],
                'ticks' => 0,
                'user' => $this->user,
            ]);
        }

        return response()->object([
            'command' => $this->command,
            'reward' => $this->generateReward(),
            'user' => $this->user,
            'metadata' => [
                'complete_steps' => $response->completeSteps,
                'details' => [
                    'id' => $response->id,
                    'name' => $response->name,
                    'description' => $response->description,
                    'step_id' => $response->requested_step_id,
                ],
                'incomplete_dependencies' => $response->incompleteDependencies,
                'incomplete_steps' => $response->incompleteSteps,
            ],
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
