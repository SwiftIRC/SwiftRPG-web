<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Map\Move;
use Illuminate\Support\Facades\Auth;

class Buildings extends Command
{
    protected $quantity = 0;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $response = app(Move::class)->buildings($user)->original;

        return response()->json([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'meta' => compact('response'),
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [];
    }
}
