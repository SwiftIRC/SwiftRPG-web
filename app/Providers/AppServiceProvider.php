<?php

namespace App\Providers;

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
        Response::macro('object', function (mixed $object) {
            $response = [
                'skill' => $object->skill,
                'experience' => $object->experience,
                'reward' => $object->reward,
                'metadata' => $object->metadata,
                'ticks' => $object->ticks,
                'seconds_until_tick' => $object->seconds_until_tick,
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
