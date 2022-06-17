<?php

namespace App\Models;

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
        'is_shop',
        'is_pub',
        'is_house',
        'is_accessible',
        'is_locked',
        'is_bed',
        'is_pilferable',
        'last_pilfered',
    ];

    public function buildings()
    {
        return $this->hasOne(Building::class, 'id', 'building_id');
    }
}
