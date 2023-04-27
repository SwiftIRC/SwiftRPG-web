<?php

namespace App\Console\Commands;

use App\Commands\Agility\Explore;
use App\Commands\Events\Engage;
use App\Commands\Firemaking\Burn;
use App\Commands\Questing\Inspect;
use App\Commands\Questing\Start;
use App\Commands\Thieving\Pickpocket;
use App\Commands\Woodcutting\Chop;
use App\Models\Command as CommandModel;
use App\Models\CommandLog;
use Illuminate\Console\Command;

class TickProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tick:process {--ticks=1}';

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
        $ticks = $this->option('ticks');

        for ($i = 0; $i < $ticks; $i++) {
            $this->processTick();
        }

        return 0;
    }

    public function processTick()
    {
        $final_tick = CommandLog::where('ticks_remaining', '>', 0)->where('ticks_remaining', '=', 1)->get();

        CommandLog::where('ticks_remaining', '>', 0)->decrement('ticks_remaining');

        $map = [
            'agility' => [
                'explore' => Explore::class,
            ],
            'eventing' => [
                'engage' => Engage::class,
            ],
            'firemaking' => [
                'burn' => Burn::class,
            ],
            'questing' => [
                'start' => Start::class,
                'inspect' => Inspect::class,
            ],
            'thieving' => [
                'pickpocket' => Pickpocket::class,
            ],
            'woodcutting' => [
                'chop' => Chop::class,
            ],
        ];

        $commands = CommandModel::all();

        $final_tick->each(function ($row) use ($commands, $map) {
            $row->command = $commands->firstWhere('id', $row->command_id);

            app($map[$row->command->class][$row->command->method])->execute($row);
        });

    }
}
