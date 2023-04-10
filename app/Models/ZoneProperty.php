<?php

namespace App\Models;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoneProperty extends Model
{
    use SoftDeletes, HasTimestamps;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
