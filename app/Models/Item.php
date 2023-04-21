<?php

namespace App\Models;

use App\Http\Response\Item as ResponseItem;
use App\Models\Effect;
use App\Models\Itemproperties;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'weight',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function effects()
    {
        return $this->belongsToMany(Effect::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function itemproperties()
    {
        return $this->belongsTo(ItemProperty::class)->withTimestamps();
    }

    public function acquire(User $user)
    {
        return new ResponseItem(
            $item = $this,
            $experience = User::firstWhere('users.id', $user->id)?->numberInInventory($this)
        );

        // [
        //     'item' => [
        //         'id' => $this->id,
        //         'name' => $this->name,
        //     ],
        //     'quantity' => User::firstWhere('users.id', $user->id?->numberInInventory($this)),
        // ];
    }
}
