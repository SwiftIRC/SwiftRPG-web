<?php

namespace App\Models;

use App\Http\Response\Skill as ResponseSkill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

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

    public function acquire()
    {
        return new ResponseSkill($this);
    }
}
