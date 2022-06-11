<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsToMany(Item::class)->withPivot('created_at', 'updated_at', 'deleted_at');
    }

    public function distinctItems()
    {
        return $this->belongsToMany(Item::class)->distinct('id');
        // Why does this line not work?
        return $this->belongsToMany(Item::class)->withPivot('created_at', 'updated_at', 'deleted_at')->distinct('id');
    }
}
