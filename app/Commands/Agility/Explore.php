<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use Illuminate\Support\Facades\Auth;
use RangeException;

class Explore extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();
        $json = json_decode($input['message']);

        if (!empty($json->meta->response->error)) {
            return response()->json([
                'error' => $json->meta->response->error,
            ]);
        }

        $response = app(Move::class)->move($input->user()->first(), json_decode($input->message)->meta->direction);

        $user->agility += $this->quantity;
        $user->save();

        return response()->json([
            'skill' => 'agility',
            'experience' => $this->quantity,
            'reward' => $this->generateReward(),
            'meta' => [
                'direction' => $input->direction,
                'response' => $response->original,
            ],
            'execute' => true,
        ]);
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $command = array_pop($input);
        $direction = array_pop($input);

        if (empty($direction) || !in_array($direction, ['north', 'south', 'east', 'west'])) {
            throw new RangeException('Direction not found.');
        }
        $response = app(Move::class)->look_at($user, $direction)->original;

        $ticks = $command->ticks + (isset($response['error']) ? 0 : $response['terrain']['movement_cost']);

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'meta' => compact('direction', 'response'),
            'ticks' => $ticks,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
