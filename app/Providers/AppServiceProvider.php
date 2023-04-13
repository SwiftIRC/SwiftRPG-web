<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
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
            Log::info($object);
            $response = [
                'skill' => $object['skill'],
                'experience' => $object['experience'] ?? 0,
                'reward_xp' => $object['reward_xp'] ?? 0,
                'reward' => $object['reward'],
                'metadata' => $object['metadata'] ?? [],
                'ticks' => $object['ticks'] ?? 0,
                'seconds_until_tick' => $object['seconds_until_tick'] ?? 0,
            ];

            return Response::make(
                $response,
                200,
                [
                    'Content-Type' => 'application/json',
                ]
            );
        });

        Response::macro('error', function (array $object) {
            Log::info($object);
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
