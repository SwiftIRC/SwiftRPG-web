<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use Illuminate\Support\Facades\Auth;

class Look extends Command
{
    protected $quantity = 0;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function log(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $direction = array_pop($input);

        if (in_array($direction, ['north', 'south', 'east', 'west'])) {
            $return = app(Move::class)->look_at($user, $direction);
        } else {
            $return = app(Move::class)->look($user);
        }

        $response = $return->original;

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'meta' => compact('direction', 'response'),
            'execute' => false,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
