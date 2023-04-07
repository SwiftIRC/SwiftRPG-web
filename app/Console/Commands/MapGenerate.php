<?php

namespace App\Console\Commands;

use App\Map\Generate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:generate {--seed=0}';

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
        $seed = $this->option('seed');

        Log::info("Generating Map - using seed: " . $seed);

        srand(crc32($seed));

        return app(Generate::class)->map();
    }
}
