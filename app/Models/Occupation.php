<?php

namespace App\Models;

use App\Models\Building;
use App\Models\Npc;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function npcs()
    {
        return $this->hasOne(Npc::class);
    }

    public function buildings()
    {
        return $this->belongsToMany(Building::class)->withTimestamps();
    }
}
