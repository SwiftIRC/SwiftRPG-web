<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Users;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Sbine\Tenancy\HasTenancy;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes, HasTenancy;

    protected $fillable = [
        'user_id',
        'gold',
        'size',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withTimestamps()->groupBy('item_id')->selectRaw('items.*, count(item_id) as quantity');
    }
}
