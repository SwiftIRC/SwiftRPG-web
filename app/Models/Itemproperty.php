<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemproperty extends Model
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

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
