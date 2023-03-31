<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'client_id',
        'webhook_address',
        'webhook_port',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'webhook_port' => 'integer',
    ];

    public function valid()
    {
        return $this->where('updated_at', '>=', now()->subMinutes(5))->get();
    }

    public function endpoints()
    {
        $clients = $this->valid();
        $endpoints = [];
        foreach ($clients as $client) {
            array_push($endpoints, 'https://' . $client->webhook_address . ':' . $client->webhook_port . '/global');
        }

        return $endpoints;
    }
}
