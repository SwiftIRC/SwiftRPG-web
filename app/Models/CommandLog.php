<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'command',
        'message',
        'created_at',
        'updated_at',
    ];
}
