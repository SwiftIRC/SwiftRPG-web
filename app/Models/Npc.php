<?php

namespace App\Models;

use App\Models\Tile;
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

    public function tile()
    {
        return $this->belongsTo(Tile::class)->withTimestamps();
    }

    public function buildings()
    {
        return $this->hasMany(Building::class)->withTimestamps();
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class)->withTimestamps();
    }
}
