<?php

namespace App\Console\Commands;

use App\Http\Response\Reward as RewardResponse;
use App\Models\Client;
use App\Models\Event;
use App\Models\Item;
use App\Models\Reward;
use App\Models\Skill;
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

        $active_event = Event::withTrashed()->firstWhere('deleted_at', '>', now());
        if (!empty($active_event)) {
            return 0;
        }

        $event = new Event();
        $event->deleted_at = now()->addMinutes(15);

        $reward = new Reward();
        $reward->save();

        $event->reward_id = $reward->id;

        $rand_event = rand(5, 5);
        switch ($rand_event) {
            case 1:
                $event->name = "Meteor Shower";
                $event->description = 'A meteor shower has started!';

                // Mining?
                break;
            case 2:
                $event->name = "Solar Flare";
                $event->description = 'A solar flare has started!';
                break;
            case 3:
                $event->name = "Solar Eclipse";
                $event->description = 'A solar eclipse has started!';
                break;
            case 4:
                $event->name = "Lunar Eclipse";
                $event->description = 'A lunar eclipse has started!';
                break;
            case 5:
                $event->name = "Dragon Nest";
                $event->description = 'A dragon has left its nest!';

                $thieving = Skill::firstWhere('name', 'thieving');
                $reward->skills()->attach($thieving->id, ['value' => 100]);
                $gold = Item::firstWhere('name', 'Gold');
                $reward->items()->attach($gold->id, ['value' => 100]);
                break;
        }

        $event->save();

        app(Client::class)->valid()->each(function ($client) use ($event, $reward) {
            post_webhook_endpoint($client->endpoint,
                [
                    'type' => 'event',
                    'data' => [
                        'event' => $event,
                        'reward' => (new RewardResponse($reward->skills, $reward->items))->toArray(),
                    ],
                ]
            );
        });

        return 0;
    }
}
