<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edge extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'terrain_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function tile()
    {
        return $this->belongsToMany(Tile::class);
    }

    public function terrain():  ? BelongsTo
    {
        return $this->belongsTo(Terrain::class);
    }
}
