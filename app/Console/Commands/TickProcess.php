<?php

namespace App\Console\Commands;

use App\Models\CommandLog;
use Illuminate\Console\Command;

class TickProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tick:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes everything that happens in a given game tick.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CommandLog::where('ticks', '>', 0)->decrement('ticks');

        return 0;
    }
}
