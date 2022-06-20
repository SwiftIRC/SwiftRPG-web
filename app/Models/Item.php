<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Effect;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Sbine\Tenancy\HasTenancy;

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

    public function inventory()
    {
        return $this->hasMany(Inventory::class)->distinct('name');
    }
}
