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
}
