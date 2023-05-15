<?php

namespace App\Http\Response;

use App\Models\Building as BuildingModel;

class Building
{
    public $building;

    public function __construct(BuildingModel $building)
    {
        $this->building = $building;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->building->id,
            'name' => $this->building->name,
            'description' => $this->building->description, 0,
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
