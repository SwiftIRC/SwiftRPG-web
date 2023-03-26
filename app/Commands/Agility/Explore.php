<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use Illuminate\Support\Facades\Auth;

class Explore extends Command
{
    protected $quantity = 5;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        $user = $input->user()->first();

        app(Move::class)->move($input->user(), $input->direction);

        $user->agility += $this->quantity;
        $user->save();

        return response()->json([
            'skill' => 'agility',
            'experience' => $this->quantity,
            'reward' => $this->generateReward(),
            'meta' => [
                'direction' => $input->direction,
            ],
            'execute' => true,
        ]);
    }

    public function log(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $direction = array_pop($input);

        if ($direction === null) {
            throw new
        } else {
            $response = Move::look_at($user, $direction);
        }

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'meta' => compact('direction'),
            'execute' => false,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
