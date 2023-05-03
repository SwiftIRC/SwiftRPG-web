<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Explore extends Command
{
    protected $quantity = 5;

    public function execute(object $input): void
    {
        $this->user = $input->user()->first();
        $json = json_decode($input->metadata);

        app(Move::class)->move($this->user, $json->direction);

        parent::execute($input);
    }

    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();

        $this->command = array_pop($input);
        $direction = array_pop($input)['direction'];

        if (empty($direction) || !in_array($direction, ['north', 'south', 'east', 'west'])) {
            return response()->object(
                [
                    'command' => $this->command,
                    'failure' => 'Direction not found.',
                    'ticks' => 0,
                ]);
        }
        $response = app(Move::class)->look_at($this->user, $direction);

        $ticks = $this->command->ticks + $response['terrain']['movement_cost'];

        $failure = null;

        $metadata = [
            'direction' => $direction,
        ];

        if (isset($response['error'])) {
            $failure = $response['error'];
            $ticks = 0;
        } else {
            $metadata = [
                'direction' => $direction,
                'x' => $response->x,
                'y' => $response->y,
                'terrain' => $response->terrain,
                'discovered_by' => User::firstWhere('id', $response->discovered_by),
                'discovered_at' => $response->discovered_at,
            ];
        }

        $reward = $this->generateReward();

        $reward->experience[0]->pivot->quantity = $response->just_discovered + $reward->experience[0]->pivot->quantity;

        return response()->object([
            'command' => $this->command,
            'metadata' => $metadata,
            'reward' => $reward,
            'ticks' => $ticks,
            'failure' => $failure,
        ]);
    }

}
