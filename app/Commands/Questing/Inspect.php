<?php

namespace App\Commands\Questing;

use App\Commands\Command;
use App\Http\Response\Quest as QuestResponse;
use App\Http\Response\Reward;
use App\Models\Quest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Inspect extends Command
{
    protected $quest;

    public function execute(object $input): void
    {
        //
    }

    public function queue(array $input = []): Response
    {
        $user = Auth::user();

        $this->command = array_pop($input);
        $quest_id = array_pop($input);
        $this->quest = Quest::with('steps')->firstWhere('id', $quest_id);

        $response = app(Quest::class)->inspect($quest_id);

        return response()->object([
            'command' => $this->command,
            'reward' => $this->generateReward(),
            'metadata' => (new QuestResponse($response))->toArray(),
            'ticks' => 0,
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
