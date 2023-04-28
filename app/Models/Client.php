<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'webhook_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'webhook_port' => 'integer',
    ];

    protected $appends = [
        'endpoint',
    ];

    public function valid()
    {
        return $this->whereDate('updated_at', '>=', now()->subMinutes(5))->get();
    }

    protected function endpoint(): Attribute
    {
        return Attribute::make( // We are accounting for both IPv4 and IPv6 here
            get:fn() => 'https://' . (str_contains($this->webhook_address, ':') ? '[' . $this->webhook_address . ']' : $this->webhook_address) . ':' . $this->webhook_port . (str_starts_with($this->webhook_path, '/') ? $this->webhook_path : '/' . $this->webhook_path),
        );
    }
}
