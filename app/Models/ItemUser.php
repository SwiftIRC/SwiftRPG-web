<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sbine\Tenancy\HasTenancy;

class ItemUser extends Model
{
    use HasTenancy, SoftDeletes, HasTimestamps;

    protected $table = 'item_user';

    protected $fillable = [
        'id',
        'user_id',
        'item_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
