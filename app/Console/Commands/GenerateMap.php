<?php

namespace App\Console\Commands;

use App\Map\Generate;
use Illuminate\Console\Command;

class GenerateMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the map on a fresh install.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return app(Generate::class)->map();
    }
}
