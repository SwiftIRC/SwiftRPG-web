<?php

namespace App\Commands\Agility;

use App\Commands\Command2;
use App\Map\Move;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Look extends Command2
{
    protected $quantity = 0;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $user = Auth::user();

        $command = array_pop($input);
        $direction = array_pop($input);

        if (in_array($direction, ['north', 'south', 'east', 'west'])) {
            $tile = app(Move::class)->look_at($user, $direction);
        } else {
            $tile = app(Move::class)->look($user);
        }

        $tile->direction = $direction;
        $tile->discovered_by = User::find($tile->discovered_by);

        return response()->object([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'metadata' => $tile,
            'ticks' => $this->quantity,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [
            'loot' => [],
            'experience' => 0,
        ];
    }
}
