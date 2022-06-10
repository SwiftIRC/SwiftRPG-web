<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'weight',
        'interactive',
        'wieldable',
        'throwable',
        'wearable',
        'consumable',
        'durability',
    ];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

    public function effects()
    {
        return $this->hasMany(App\Models\Effect::class);
    }
}
