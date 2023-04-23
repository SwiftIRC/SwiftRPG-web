<?php

namespace App\Http\Response;

use App\Http\Response\Reward;
use App\Models\Command;
use App\Models\User;

class Valid
{
    public $webhook_id;
    public $command;
    public $failure;
    public $metadata;
    public $reward;
    public $seconds_until_tick;
    public $ticks;
    public $user;

    public function __construct(Command $command, Reward $reward, mixed $metadata = null, mixed $failure = null, User $user, $webhook_id = null, $ticks = null)
    {
        $this->command = $command;
        $this->webhook_id = $webhook_id;
        $this->failure = $failure;
        $this->metadata = $metadata;
        $this->reward = $reward;
        $this->ticks = $ticks ?? $command->ticks;
        $this->seconds_until_tick = seconds_until_tick($this->ticks);
        $this->user = $user;
    }

    public function toArray(): array
    {
        return [
            'reward' => [
                'experience' => $this->reward->experience?->map(fn($skill) => [
                    'skill' => [
                        'name' => $skill->skill->name,
                    ],
                    'quantity' => $skill->skill->pivot->quantity,
                    'total' => $skill->skill->total,
                ]),
                'loot' => $this->reward->loot?->map(fn($item) => [
                    'item' => [
                        'name' => $item->item->name,
                        'description' => $item->item->description,
                    ],
                    'quantity' => $item->item->pivot->quantity,
                    'total' => $item->item->total,
                ]),
            ],
            'command' => [
                'name' => $this->command->class,
                'method' => $this->command->method,
                'verb' => $this->command->verb,
                'emoji' => $this->command->emoji,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'metadata' => $this->metadata,
            'ticks' => $this->ticks,
            'seconds_until_tick' => $this->seconds_until_tick,
            'failure' => $this->failure,
            'webhook_id' => $this->webhook_id,
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
