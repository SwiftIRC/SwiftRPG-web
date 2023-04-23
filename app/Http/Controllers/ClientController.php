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
            'webhook_path' => 'required|string',
            'webhook_address' => 'string|nullable',
        ]);

        return Client::upsert(
            [
                'client_id' => $request->input('client-id'),
                'webhook_address' => $request->input('webhook_address') ?? $request->ip(),
                'webhook_port' => $request->input('webhook_port'),
                'webhook_path' => $request->input('webhook_path'),
            ],
            ['client_id'],
            ['webhook_address', 'webhook_port', 'webhook_path']
        );
    }
}
