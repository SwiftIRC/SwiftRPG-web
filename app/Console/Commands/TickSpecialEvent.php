<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Quest;
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
        if (rand(0, 1000) > 0) {
            return 0;
        }

        $active_quest = Quest::withTrashed()->firstWhere('deleted_at', '>', now());
        if (!empty($active_quest)) {
            return 0;
        }

        $quest = new Quest();
        $quest->deleted_at = now()->addMinutes(15);

        $event = rand(1, 5);
        switch ($event) {
            case 1:
                $quest->name = "Meteor Shower";
                $quest->description = 'A meteor shower has started!';
                break;
            case 2:
                $quest->name = "Solar Flare";
                $quest->description = 'A solar flare has started!';
                break;
            case 3:
                $quest->name = "Solar Eclipse";
                $quest->description = 'A solar eclipse has started!';
                break;
            case 4:
                $quest->name = "Lunar Eclipse";
                $quest->description = 'A lunar eclipse has started!';
                break;
            case 5:
                $quest->name = "Dragon Nest";
                $quest->description = 'A dragon has left its nest!';
                break;
        }

        $quest->save();

        app(Client::class)->valid()->each(function ($client) use ($quest) {
            post_webhook_endpoint($client->endpoint, $quest);
        });

        return 0;
    }
}
