<?php

namespace App\Models;

use App\Models\Npc;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function npcs()
    {
        return $this->hasOne(Npc::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class);
    }
}
