<?php

namespace App\Http\Response;

class Loot
{
    public $name;
    public $quantity;
    public $total;

    public function __construct(string $name, int $quantity, int $total)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->total = $total;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'total' => $this->total,
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
