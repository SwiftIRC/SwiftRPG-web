<?php

namespace App\Models;

use Sbine\Tenancy\HasTenancy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class CommandLog extends Model
{
    use HasFactory, HasTimestamps, HasTenancy;

    protected $fillable = [
        'user_id',
        'command',
        'message',
    ];
}
