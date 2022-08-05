<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TileEdge extends Model
{
    use HasFactory;

    protected $fillable = [
        'tile_id',
        'edge_id',
        'direction',
        'is_road',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
