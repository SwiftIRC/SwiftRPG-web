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
            $reward = new Reward();

            $response = new Valid(
                $object['reward'] ?? $reward,
                $object['metadata'] ?? null,
                $object['ticks'] ?? 0,
                $object['failure'] ?? null,
            );

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
