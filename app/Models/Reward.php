<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    public $timestamps = false;

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('value');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('value');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
