<?php

namespace App\Providers;

use App\Http\Response\Reward;
use App\Http\Response\Valid;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('object', function (array $object) {
            $reward = new Reward(
                $object['reward']['experience'] ?? 0,
                $object['reward']['loot'] ?? []
            );
            $response = new Valid(
                $object['skill'],
                $object['experience'] ?? 0,
                $reward,
                $object['metadata'] ?? [],
                $object['ticks'] ?? 0
            );
            // $response = [
            //     'skill' => $object['skill'],
            //     'experience' => $object['experience'] ?? 0,
            //     'reward' => [
            //         'loot' => $object['reward']['loot'] ?? [],
            //         'experience' => $object['reward']['experience'],
            //     ],
            //     'metadata' => $object['metadata'] ?? [],
            //     'ticks' => $object['ticks'] ?? 0,
            //     'seconds_until_tick' => seconds_until_tick($object['ticks'] ?? 0),
            // ];

            return Response::make(
                $response,
                200,
                [
                    'Content-Type' => 'application/json',
                ]
            );
        });

        Response::macro('error', function (array $object) {
            $response = [
                'error' => $object['error'],
                'metadata' => $object['metadata'] ?? [],
            ];

            return Response::make(
                $response,
                200,
                [
                    'Content-Type' => 'application/json',
                ]
            );
        });
    }
}
