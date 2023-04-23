<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('quantity');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
