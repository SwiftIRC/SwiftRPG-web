<?php

namespace App\Console\Commands;

use App\Map\Regenerate;
use Illuminate\Console\Command;

class MapRegenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerates resources on the map; use in a cron job.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return app(Regenerate::class)->map();
    }
}
