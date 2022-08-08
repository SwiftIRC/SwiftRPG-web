<?php

namespace App\Models;

use App\Models\User;
use App\Models\Effect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Item extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
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

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function effects()
    {
        return $this->belongsToMany(Effect::class)->withTimestamps();
    }

    public function user()
    {
        return $this->hasMany(User::class)->withTimestamps();
    }
}
