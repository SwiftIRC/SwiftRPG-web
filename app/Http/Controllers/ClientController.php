<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'client-id' => 'required|string',
            'webhook_port' => 'required|integer',
        ]);

        return Client::upsert([
            'client_id' => $request->input('client-id'),
            'webhook_address' => $request->ip(),
            'webhook_port' => $request->input('webhook_port'),
        ], ['client_id', 'webhook_port']);
    }
}
