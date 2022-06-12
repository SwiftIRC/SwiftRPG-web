<?php

namespace App\Skills;

use RangeException;
use App\Models\CommandLog;

class Skill
{
    public function __call($methodName, $parameters)
    {
        $class = explode("\\", get_class($this));
        $action = strtolower(end($class)) . "." . $methodName;

        $last_run = CommandLog::where('command', $action)->latest()->first();
        if ($last_run && $last_run->created_at >= now()->subMinutes(1)) {
            throw new RangeException('You can only run this command once every minute.');
        }

        CommandLog::create([
            'command' => $action,
            'message' => json_encode($this->$methodName($parameters)),
        ]);
    }
}
