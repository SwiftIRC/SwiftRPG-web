<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Effect;
use App\Models\Inventory;


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
        return $this->belongsTo(User::class);
    }

    public function effects()
    {
        return $this->hasMany(Effect::class);
    }

    public function inventory()
    {
        return $this->belongsToMany(Inventory::class)->withPivot('created_at', 'updated_at', 'deleted_at');
    }
}
