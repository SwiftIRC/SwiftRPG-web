<?php

namespace App\Models;

use App\Models\Effect;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EffectProperty extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function effects()
    {
        return $this->hasMany(Effect::class);
    }
}
