<?php

namespace App\Http\Response;

use App\Http\Response\Reward;

class Valid
{
    public $reward;
    public $metadata;
    public $ticks;
    public $seconds_until_tick;
    public $log_id;

    public function __construct(Reward $reward, mixed $metadata = null, int $ticks = 0)
    {
        $this->reward = $reward;
        $this->metadata = $metadata;
        $this->ticks = $ticks;
        $this->seconds_until_tick = seconds_until_tick($ticks);
    }

    public function toArray(): array
    {
        return [
            'reward' => $this->reward,
            'metadata' => $this->metadata,
            'ticks' => $this->ticks,
            'seconds_until_tick' => $this->seconds_until_tick,
            'log_id' => $this->log_id,
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
