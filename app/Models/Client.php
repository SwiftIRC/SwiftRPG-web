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
        return $this->where('updated_at', '>=', now()->subMinutes(5))->get();
    }

    protected function endpoint(): Attribute
    {
        return Attribute::make(
            get:fn() => 'https://' . $this->webhook_address . ':' . $this->webhook_port . '/global',
        );
    }
}
