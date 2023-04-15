<?php

namespace App\Http\Response;

use App\Http\Response\Loot;

class Reward
{
    public $loot;
    public $experience;

    public function __construct(int $experience = 0, array $loot = [])
    {
        $this->loot = [];

        foreach ($loot as $item) {
            $this->loot[] = new Loot($item['name'], $item['quantity'], $item['total']);
        }

        $this->experience = $experience;
    }

    public function toArray(): array
    {
        return [
            'experience' => $this->experience,
            'loot' => $this->loot,
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
