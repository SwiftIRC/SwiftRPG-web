<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TickSpecialEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tick:specialevent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'There is a chance each tick that a special event will occur.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
