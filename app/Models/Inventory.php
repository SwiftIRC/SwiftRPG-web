<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gold',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withTimestamps()->groupBy('pivot_item_id')->selectRaw('items.*, count(item_id) as quantity');
    }
}
