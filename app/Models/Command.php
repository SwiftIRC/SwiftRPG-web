<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasTimestamps;

    protected $fillable = [
        'class',
        'method',
        'verb',
        'ticks',
        'log',
        'movement_cost',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
