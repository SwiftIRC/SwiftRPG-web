<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tiles()
    {
        return $this->hasMany(Tile::class);
    }

    public function npcs()
    {
        return $this->belongsToMany(Npc::class)->withTimestamps();
    }

    public function zones()
    {
        return $this->belongsTo(Zone::class)->withTimestamps();
    }
}
