<?php

namespace App\Http\Response;

use App\Http\Response\Reward;
use App\Models\Command;

class Valid
{
    public $command;
    public $reward;
    public $metadata;
    public $ticks;
    public $seconds_until_tick;
    public $command_id;
    public $failure;

    public function __construct(Command $command, Reward $reward, mixed $metadata = null, int $ticks = 0, mixed $failure = null)
    {
        $this->command = $command->id;
        $this->reward = $reward;
        $this->metadata = $metadata;
        $this->ticks = $ticks;
        $this->seconds_until_tick = seconds_until_tick($ticks);
        $this->failure = $failure;
    }

    public function toArray(): array
    {
        return [
            'reward' => [
                'experience' => $this->reward->experience->map(fn($skill) => [
                    'skill' => [
                        'name' => $skill->skill->name,
                    ],
                    'quantity' => $skill->skill->pivot->quantity,
                    'total' => $skill->skill->total,
                ]),
                'loot' => $this->reward->loot->map(fn($item) => [
                    'item' => [
                        'name' => $item->item->name,
                        'description' => $item->item->description,
                    ],
                    'quantity' => $item->item->pivot->quantity,
                    'total' => $item->item->total,
                ]),
            ],
            'metadata' => $this->metadata,
            'ticks' => $this->ticks,
            'seconds_until_tick' => $this->seconds_until_tick,
            'failure' => $this->failure,
            'command_id' => $this->command_id,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function __debugInfo()
    {
        return $this->toArray();
    }

}
