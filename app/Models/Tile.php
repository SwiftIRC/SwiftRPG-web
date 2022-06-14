<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Tile extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'discovered_by',
        'psuedo_id',
        'x',
        'y',
        'max_trees',
        'available_trees',
        'last_disturbed',
    ];

    public function buildings()
    {
        return $this->belongsToMany(Building::class)->withTimestamps();
    }

    public function npcs()
    {
        return $this->belongsToMany(Npc::class)->withTimestamps();
    }

    public function edges()
    {
        return $this->belongsToMany(Edge::class)->withTimestamps()->withPivot('direction', 'is_road');
    }

    public function terrains()
    {
        return $this->belongsToMany(Terrain::class)->withTimestamps();
    }
}
