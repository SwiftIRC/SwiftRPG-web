<?php

namespace App\Models;

use Sbine\Tenancy\HasTenancy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommandLog extends Model
{
    use HasFactory, HasTenancy;

    protected $fillable = [
        'user_id',
        'command',
        'message',
        'created_at',
        'updated_at',
    ];
}
