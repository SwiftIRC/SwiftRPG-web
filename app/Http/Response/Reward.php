<?php

namespace App\Http\Response;

use App\Http\Response\Loot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;

class Reward
{
    public $loot;
    public $experience;

    public function __construct(Collection | Collect | null $experience = null, Collection | Collect | null $loot = null)
    {
        $this->experience = $experience;
        $this->loot = $loot;
    }

    public function toArray(): array
    {
        $experience = $this->experience?->toArray();
        $loot = $this->loot?->toArray();

        return compact(['experience', 'loot']);
    }

    public function collect(): Collect
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

    public function __unset($name)
    {
        unset($this->$name);
    }

    public function __call($name, $arguments)
    {
        return $this->$name(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::$name(...$arguments);
    }

}
