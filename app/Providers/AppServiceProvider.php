<?php

namespace App\Providers;

use App\Http\Response\Reward;
use App\Http\Response\Valid;
use Illuminate\Support\Facades\Auth;
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
            $reward = new Reward();

            $response = new Valid(
                $object['command'],
                $object['reward'] ?? $reward,
                $object['metadata'] ?? null,
                $object['failure'] ?? null,
                $object['user'] ?? Auth::user(),
                $object['webhook_id'] ?? null,
                $object['ticks'] ?? $object['command']->ticks,
            );

            return Response::make(
                $response->toArray(),
                200,
                [
                    'Content-Type' => 'application/json',
                ]
            );
        });
    }
}
