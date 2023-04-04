<?php

namespace App\Console\Commands;

use App\Commands\Agility\Explore;
use App\Commands\Firemaking\Burn;
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
        $where = CommandLog::where('ticks_remaining', '>', 0);

        $map = [
            'agility' => [
                'explore' => Explore::class,
            ],
            'firemaking' => [
                'burn' => Burn::class,
            ],
            'thieving' => [
                'pickpocket' => Pickpocket::class,
            ],
            'woodcutting' => [
                'chop' => Chop::class,
            ],
        ];

        $commands = CommandModel::all();

        $rows = $where->get();

        foreach ($rows as $row) {
            if ($row->ticks == 1) {
                $row->command = $commands->where('id', $row->command_id)->first();

                app($map[$row->command->class][$row->command->method])->execute($row);
            }
        }

        $where->decrement('ticks_remaining');

        return 0;
    }
}
