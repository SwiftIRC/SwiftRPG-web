<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function npcs()
    {
        return $this->belongsToMany(Npc::class)->withPivot('value');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('value');
    }
}
