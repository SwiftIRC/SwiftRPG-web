<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\InventoryItems;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

    public function inventory_items()
    {
        return $this->hasMany(App\Models\Item::class);
    }
}
