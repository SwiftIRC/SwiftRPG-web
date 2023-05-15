<?php

namespace App\Http\Response;

use App\Models\Npc as NpcModel;

class Npc
{
    public $npc;

    public function __construct(NpcModel $npc)
    {
        $this->npc = $npc;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->npc->id,
            'first_name' => $this->npc->first_name,
            'last_name' => $this->npc->last_name,
            'gender' => $this->npc->gender,
            'species' => $this->npc->species,
            'occupation' => (!$this->npc->occupation ? null : [
                'id' => $this->npc->occupation->id,
                'name' => $this->npc->occupation->name,
                'description' => $this->npc->occupation->description,
            ]),
            'skills' => $this->npc->skills->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                    'quantity' => $skill->pivot->quantity,
                ];
            }),
        ];
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
