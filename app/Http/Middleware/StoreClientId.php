<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

class StoreClientId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // abort_if(empty($request->header('X-Client-Id')), 403, "X-Client-Id header is required");

        $client = Client::firstWhere('client_id', $request->header('X-Client-Id'));
        session()->put('clientId', $client?->id);

        return $next($request);
    }
}
