<?php

namespace App\Commands\Agility;

use App\Commands\Command;
use App\Http\Response\Npc;
use App\Map\Move;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NPCs extends Command
{
    public function queue(array $input = []): Response
    {
        $this->user = Auth::user();
        $this->command = array_pop($input);

        $npcs = app(Move::class)->npcs($this->user)->map(function ($npc) {
            return (new Npc($npc))->toArray();
        });

        return response()->object([
            'command' => $this->command,
            'metadata' => $npcs,
            'reward' => $this->generateReward(),
        ]);
    }
}
