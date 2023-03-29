<?php

namespace App\Models;

use App\Models\Effect;
use App\Models\Itemproperties;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function itemproperties()
    {
        return $this->belongsTo(Itemproperty::class)->withTimestamps();
    }
}
