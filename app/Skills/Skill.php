<?php

namespace App\Skills;

use App\Models\Command;
use App\Models\CommandLog;
use Illuminate\Support\Facades\Log;
use RangeException;

class Skill
{
    public function __call(string $methodName, array $parameters)
    {
        abort_if(empty(session()->get('clientId')), 403, "X-Client-Id header is required");

        $exploded = explode("\\", get_class($this));
        $class = strtolower(end($exploded));

        $command = Command::where('class', $class)->where('method', $methodName)->first();

        if (empty($command)) {
            Log::error("Command not found: " . $class . "." . $methodName);
            throw new RangeException('Command not found.');
        }

        $last_run = CommandLog::where('ticks_remaining', '>', 0)->latest()->first();
        if ($last_run) {
            $last_run->command = $last_run->command()->first();

            $plural_ticks = $last_run->ticks_remaining > 1 ? 's' : '';
            $plural_seconds = seconds_until_tick($last_run->ticks_remaining) > 1 ? 's' : '';

            throw new RangeException($last_run->ticks_remaining . ' tick' . $plural_ticks . ' (' . seconds_until_tick($last_run->ticks_remaining) . ' second' . $plural_seconds . ') remaining until you are done with ' . $last_run->command->verb . ".");
        }

        $parameters = [[
            ...$parameters,
            $command,
        ]];

        $response = $this->$methodName(...$parameters);

        $ticks = $response->original->ticks ?? $command->ticks;

        if ($command->log) {
            $log = CommandLog::create([
                'client_id' => session()->get('clientId'),
                'command_id' => $command->id,
                'ticks' => $ticks,
                'ticks_remaining' => $ticks,
                'metadata' => json_encode($response->original->metadata ?? null),
            ]);

            $content = $response->original;
            $content['command_id'] = $log->id;
            $response->setContent($content);
        }

        return $response;
    }
}
