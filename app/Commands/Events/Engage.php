<?php

namespace App\Commands\Events;

use App\Commands\Command;
use App\Http\Response\Reward;
use App\Models\Client;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Engage extends Command
{
    protected $event;

    public function execute(object $input): void
    {
        $this->user = $input->user()->first();
        $this->command = $input->command;
        $event_json = json_decode($input->metadata, true);
        $this->event = Event::withTrashed()->firstWhere('id', $event_json['event_id']);

        $reward = $this->generateReward();

        $reward->experience?->each(function ($skill) {
            $this->user->addXp($skill->id, $skill->pivot->quantity);
        });
        $reward->loot?->each(function ($item) {
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

    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $this->command = array_pop($input);

        $this->event = Event::withTrashed()->where('deleted_at', '>', now())->first();
        if (empty($this->event)) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'No active event.',
                    'ticks' => 0,
                ],
                200
            );
        }

        return response()->object([
            'command' => $this->command,
            'metadata' => ['event_id' => $this->event->id],
            'reward' => $this->generateReward(),
            'ticks' => $this->command->ticks,
        ]);
    }

    /**
     *
     * @return Reward
     */
    protected function generateReward(): Reward
    {
        $skills = $this->event->getSkillRewardsWithTotals($this->user);
        $items = $this->event->getItemRewardsWithTotals($this->user);

        return new Reward(
            $skills,
            $items,
        );
    }
}
