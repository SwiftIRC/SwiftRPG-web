<?php

namespace App\Skills;

use App\Models\Command;
use App\Models\CommandLog;
use RangeException;

class Skill
{
    public function __call(string $methodName, array $parameters)
    {
        $exploded = explode("\\", get_class($this));
        $class = strtolower(end($exploded));

        $command = Command::where('class', $class)->where('method', $methodName)->first();

        if (empty($command)) {
            throw new RangeException('Command not found.');
        }

        $command_id = $command->id;

        $last_run = CommandLog::where('command_id', $command_id)->latest()->first();
        if ($last_run && $last_run->created_at >= now()->subMinutes(1)) {
            throw new RangeException('You can only run this command once every one (1) minute. Remaining seconds: ' . now()->diffInSeconds($last_run->created_at->addMinutes(1)));
        }

        $output = $this->$methodName($parameters);

        CommandLog::create([
            'command_id' => $command_id,
            'message' => json_encode($output),
        ]);

        return $output;
    }
}
