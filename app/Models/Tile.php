<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Tile extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'discovered_by',
        'x',
        'y',
        'max_trees',
        'available_trees',
        'north_edge',
        'east_edge',
        'south_edge',
        'west_edge',
        'last_disturbed',
    ];
}
