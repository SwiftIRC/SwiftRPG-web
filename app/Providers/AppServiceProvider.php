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
                $object['command_id'] ?? null,
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

        Response::macro('reward', function (array $object) {
            $response = [
                'reward' => $object['reward'],
                'metadata' => $object['metadata'] ?? [],
                'ticks' => $object['ticks'] ?? 0,
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
            $response = [
                'failure' => $object['error'],
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
