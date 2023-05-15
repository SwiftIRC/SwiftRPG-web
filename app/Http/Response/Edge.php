<?php

namespace App\Http\Response;

use App\Models\Edge as EdgeModel;

class Edge
{
    public $edge;

    public function __construct(EdgeModel $edge)
    {
        $this->edge = $edge;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->edge->id,
            'name' => $this->edge->name,
            'description' => $this->edge->description,
            'direction' => $this->edge->pivot->direction,
            'is_road' => $this->edge->pivot->is_road,
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
