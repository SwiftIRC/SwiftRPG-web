<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Look extends Command
{
    protected $quantity = 0;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $command = array_pop($input);
        $direction = array_pop($input);

        if (in_array($direction, ['north', 'south', 'east', 'west'])) {
            $response = app(Move::class)->look_at($user, $direction);
        } else {
            $response = app(Move::class)->look($user);
        }

        $metadata = [
            'direction' => $direction,
            'response' => $response,
            'discovered_by' => User::find($response->discovered_by),
        ];

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'metadata' => $metadata,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
