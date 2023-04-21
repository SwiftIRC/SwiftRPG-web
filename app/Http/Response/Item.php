<?php

namespace App\Http\Response;

use App\Models\Item as ModelItem;
use Illuminate\Support\Collection;

class Item
{
    public $item;

    public function __construct(ModelItem $item)
    {
        $this->item = $item;
    }

    public function toArray(): array
    {
        return [
            'details' => [
                'id' => $this->item->id,
                'name' => $this->item->name,
                'description' => $this->item->description,
            ],
            'gained' => $this->item->pivot->quantity,
            'total' => $this->item->total,
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
