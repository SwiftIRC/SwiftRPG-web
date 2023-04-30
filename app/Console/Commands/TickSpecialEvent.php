<?php

namespace App\Console\Commands;

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
    protected $signature = 'tick:specialevent {--trigger=false}';

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
        $active_event = Event::withTrashed()->firstWhere('deleted_at', '>', now());
        if (!empty($active_event)) {
            $end_date = $active_event->deleted_at;

            // When there're N minutes left we will send a notification to all clients
            if (now()->diffInMinutes($end_date) <= 1) {
                app(Client::class)->valid()->each(function ($client) use ($active_event) {
                    post_webhook_endpoint(
                        $client->endpoint,
                        [
                            'type' => 'event_ending',
                            'data' => [
                                'event' => [
                                    'name' => $active_event->name,
                                    'description' => $active_event->description,
                                ],
                                'seconds_remaining' => now()->diffInSeconds($active_event->deleted_at),
                            ],
                        ]
                    );
                });
            } elseif (now()->diffInMinutes($end_date) == 5) {
                app(Client::class)->valid()->each(function ($client) use ($active_event) {
                    post_webhook_endpoint(
                        $client->endpoint,
                        [
                            'type' => 'event_ending',
                            'data' => [
                                'event' => [
                                    'name' => $active_event->name,
                                    'description' => $active_event->description,
                                ],
                                'seconds_remaining' => now()->diffInSeconds($active_event->deleted_at),
                            ],
                        ]
                    );
                });
            }

            return 0;
        }

        if ($this->option('trigger') == "false" && rand(0, 1000) > 0) {
            return 0;
        }

        $event_obj = new Event();
        $event_obj->deleted_at = now()->addMinutes(15);

        $reward_obj = new Reward();
        $reward_obj->save();

        $event_obj->reward_id = $reward_obj->id;

        $rand_event = rand(5, 5);
        switch ($rand_event) {
            case 1:
                $event_obj->name = "Meteor Shower";
                $event_obj->description = 'A meteor shower has started!';

                // Mining?
                break;
            case 2:
                $event_obj->name = "Solar Flare";
                $event_obj->description = 'A solar flare has started!';
                break;
            case 3:
                $event_obj->name = "Solar Eclipse";
                $event_obj->description = 'A solar eclipse has started!';
                break;
            case 4:
                $event_obj->name = "Lunar Eclipse";
                $event_obj->description = 'A lunar eclipse has started!';
                break;
            case 5:
                $event_obj->name = "Dragon Nest";
                $event_obj->description = 'A dragon has left its nest!';

                $thieving = Skill::firstWhere('name', 'thieving');
                $reward_obj->skills()->attach($thieving->id, ['quantity' => 100]);
                $gold = Item::firstWhere('name', 'Gold');
                $reward_obj->items()->attach($gold->id, ['quantity' => 100]);
                break;
        }

        $event_obj->save();

        $reward = [
            'experience' => $reward_obj->skills?->map(fn($skill) => $skill->acquire()->toArray()),
            'loot' => $reward_obj->items?->map(fn($item) => $item->acquire()->toArray()),
        ];

        $event = [
            'name' => $event_obj->name,
            'description' => $event_obj->description,
        ];

        app(Client::class)->valid()->each(function ($client) use ($event, $reward) {
            post_webhook_endpoint(
                $client->endpoint,
                [
                    'type' => 'event_start',
                    'data' => compact('event', 'reward'),
                ]
            );
        });

        return 0;
    }
}
