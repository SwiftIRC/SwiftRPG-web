<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Effect extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'health_change',
        'mana_change',
        'stamina_change',
        'strength_change',
        'luck_change',
        'damage_change',
        'armor_change',
        'speed_change',
        'critical_chance',
        'critical_damage',
        'compounds',
        'compound_chance',
        'speed_change',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function effectproperties()
    {
        return $this->belongsToMany(EffectProperty::class)->withTimestamps();
    }
}
