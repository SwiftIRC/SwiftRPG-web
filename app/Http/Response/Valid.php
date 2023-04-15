<?php

namespace App\Http\Response;

use App\Http\Response\Reward;

class Valid
{
    public $skill;
    public $experience;
    public $reward;
    public $metadata;
    public $ticks;
    public $seconds_until_tick;

    public function __construct(string $skill, int $experience = 0, Reward $reward, mixed $metadata = null, int $ticks = 0)
    {
        $this->skill = $skill;
        $this->experience = $experience;
        $this->reward = $reward;
        $this->metadata = $metadata;
        $this->ticks = $ticks;
        $this->seconds_until_tick = seconds_until_tick($ticks);
    }

    public function toArray(): array
    {
        return [
            'skill' => $this->skill,
            'experience' => $this->experience,
            'reward' => [
                'loot' => $this->reward->loot,
                'experience' => $this->reward->experience,
            ],
            'metadata' => $this->metadata,
            'ticks' => $this->ticks,
            'seconds_until_tick' => $this->seconds_until_tick,
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