<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use Illuminate\Support\Facades\Auth;

class NPCs extends Command
{
    protected $quantity = 0;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function log(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $response = app(Move::class)->npcs($user)->original;

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'meta' => compact('response'),
            'execute' => false,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
