<?php

namespace App\Commands\Agility;

use App\Commands\Command2;
use App\Map\Move;
use Illuminate\Support\Facades\Auth;

class Buildings extends Command2
{
    protected $quantity = 0;

    public function execute(object $input): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }

    public function queue(array $input = []): \Illuminate\Http\Response
    {
        $user = Auth::user();

        $buildings = app(Move::class)->buildings($user);

        return response()->object([
            'skill' => 'agility',
            'experience' => $user->agility,
            'reward' => $this->generateReward(),
            'metadata' => $buildings,
        ]);
    }

    protected function generateReward($total = 0): array
    {
        return [
            'loot' => [],
            'experience' => $this->quantity,
        ];
    }
}
