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
        $json = json_decode($input->metadata);
        $quest = Collection::make([$json->response])[0];
        $this->quest = Quest::with('steps')->firstWhere('id', $quest->id);

        if (count($quest->incompleteSteps) == 1 && $quest->incompleteSteps[0]->id == $quest->requested_step_id) {
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

        $step_id = $request->step_id;
        $quest_id = $request->quest_id;

        $this->quest = Quest::with('steps')->firstWhere('id', $quest_id);

        $ticks = $this->quest->steps->filter(function ($step) use ($step_id) {
            return $step->id == $step_id;
        })->first()->ticks;

        $response = app(Quest::class)->start($quest_id, $step_id ?? 1);

        if ($response->completeStep != null) {
            return response()->object([
                'command' => $this->command,
                'failure' => 'You have already completed this step of the quest!',
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
                    'name' => $response->name,
                    'description' => $response->description,
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
