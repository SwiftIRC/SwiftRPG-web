<?php

namespace App\Models;

use App\Models\Building;
use App\Models\Occupation;
use App\Models\Tile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Npc extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'species',
        'gender',
        'occupation_id',
        'thieving',
        'fishing',
        'mining',
        'woodcutting',
        'firemaking',
        'cooking',
        'smithing',
        'fletching',
        'crafting',
        'herblore',
        'agility',
        'farming',
        'hunter',
    ];

    public function tile()
    {
        return $this->belongsTo(Tile::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class)->withTimestamps();
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('value');
    }
}
