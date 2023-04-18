<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'reward_id',
        'name',
        'description',
        'ticks',
    ];

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
