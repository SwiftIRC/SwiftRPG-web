<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Npc extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function buildings()
    {
        return $this->hasMany(Building::class)->withTimestamps();
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
}
