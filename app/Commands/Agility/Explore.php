<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Explore extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();

        $json = json_decode($input->metadata);

        $response = app(Move::class)->move($user, $json->direction);

        $user->agility += $this->quantity;
        $user->save();

        return response()->json($response);
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $command = array_pop($input);
        $direction = array_pop($input);

        if (empty($direction) || !in_array($direction, ['north', 'south', 'east', 'west'])) {
            throw new RangeException('Direction not found.');
        }
        $response = app(Move::class)->look_at($user, $direction);

        $ticks = $command->ticks + (isset($response['error']) ? 0 : $response['terrain']['movement_cost']);

        if (isset($response['error'])) {
            $metadata = [
                'direction' => $direction,
                'error' => $response['error'],
            ];
        } else {
            $metadata = [
                'direction' => $direction,
                'x' => $response->x,
                'y' => $response->y,
                'terrain' => $response->terrain,
                'discovered_by' => User::find($response->discovered_by),
                'discovered_at' => $response->discovered_at,
            ];
        }

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'metadata' => $metadata,
            'ticks' => $ticks,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
