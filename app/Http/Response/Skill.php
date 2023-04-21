<?php

namespace App\Http\Response;

use App\Models\Skill as ModelSkill;
use Illuminate\Support\Collection;

class Skill
{
    public $skill;

    public function __construct(ModelSkill $skill)
    {
        $this->skill = $skill;
    }

    public function toArray(): array
    {
        return [
            'details' => [
                'id' => $this->skill->id,
                'name' => $this->skill->name,
            ],
            'gained' => $this->skill->pivot->quantity,
            'total' => $this->skill->total,
        ];
    }

    public function collect(): Collection
    {
        return collect($this->toArray());
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function __debugInfo(): array
    {
        return $this->toArray();
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }
}
