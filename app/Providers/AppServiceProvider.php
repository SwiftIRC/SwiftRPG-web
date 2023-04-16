<?php

namespace App\Providers;

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
            $response = new Valid(
                $object['reward'] ?? null,
                $object['metadata'] ?? [],
                $object['ticks'] ?? 0
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
