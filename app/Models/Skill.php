<?php

namespace App\Models;

use App\Http\Response\Skill as ResponseSkill;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function npcs()
    {
        return $this->belongsToMany(Npc::class)->withPivot('quantity');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('quantity');
    }

    public function acquire(User $user)
    {
        return new ResponseSkill($this);
    }
}
