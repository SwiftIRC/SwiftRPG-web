<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tile extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'discovered_by',
        'psuedo_id',
        'x',
        'y',
        'max_trees',
        'available_trees',
        'last_disturbed',
        'terrain_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function buildings(): ?BelongsToMany
    {
        return $this->belongsToMany(Building::class);
    }

    public function npcs(): ?BelongsToMany
    {
        return $this->belongsToMany(Npc::class);
    }

    public function edges(): ?BelongsToMany
    {
        return $this->belongsToMany(Edge::class)->withPivot('direction', 'is_road');
    }

    public function terrain(): ?BelongsTo
    {
        return $this->belongsTo(Terrain::class);
    }

    public function users(): ?BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
