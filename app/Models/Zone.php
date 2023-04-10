<?php

namespace App\Models;

use App\Models\Occupation;
use App\Models\ZoneProperty;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function buildings()
    {
        return $this->hasOne(Building::class, 'id', 'building_id');
    }

    public function occupations()
    {
        return $this->belongsToMany(Occupation::class)->withTimestamps();
    }

    public function zoneproperties()
    {
        return $this->belongsToMany(ZoneProperty::class)->withTimestamps();
    }
}
