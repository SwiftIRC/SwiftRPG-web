<?php

namespace App\Models;

use Sbine\Tenancy\HasTenancy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class MoveLog extends Model
{
    use HasFactory, HasTimestamps, HasTenancy;

    protected $fillable = [
        'user_id',
        'old_tile_id',
        'new_tile_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
