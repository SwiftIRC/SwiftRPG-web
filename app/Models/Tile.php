<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected $appends = [
        'just_discovered',
    ];

    public function buildings(): ?BelongsToMany
    {
        return $this->belongsToMany(Building::class);
    }

    public function npcs(): ?BelongsToMany
    {
        return $this->belongsToMany(Npc::class)->withTimestamps();
    }

    public function edges(): ?BelongsToMany
    {
        return $this->belongsToMany(Edge::class)->withPivot('direction', 'is_road');
    }

    public function terrain(): ?BelongsTo
    {
        return $this->belongsTo(Terrain::class);
    }

    public function users(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'tile_id');
    }

    protected function justDiscovered(): Attribute
    {
        return Attribute::make(
            get:fn($value) => ($this->discovered_by === null ? 50 : 0),
        );
    }
}
