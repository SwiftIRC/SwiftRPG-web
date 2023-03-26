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

        $last_run = CommandLog::where('ticks', '>', 0)->latest()->first();
        if ($last_run) {
            $last_run->command = $last_run->command()->first();

            throw new RangeException($last_run->ticks . ' tick' . ($command->ticks > 1 ? 's' : '') . ' remaining until you are done with ' . $last_run->command->verb . ".");
        }

        $output = $this->$methodName($parameters);

        if ($command->log) {
            CommandLog::create([
                'command_id' => $command->id,
                'message' => json_encode($output->original),
                'ticks' => $command->ticks,
            ]);
        }

        return $output;
    }
}
