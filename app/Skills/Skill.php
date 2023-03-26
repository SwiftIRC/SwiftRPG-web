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
        if ($last_run && $last_run->ticks > 0) {
            throw new RangeException('You can only run this command once every ' . $command->ticks . ' tick(s).');
        }

        $output = $this->$methodName($parameters);

        CommandLog::create([
            'command_id' => $command_id,
            'message' => json_encode($output->original),
        ]);

        return $output;
    }
}
