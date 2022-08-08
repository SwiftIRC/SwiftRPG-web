<?php

namespace App\Models;

use App\Models\Tile;
use App\Models\ItemUser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'hitpoints',
        'mana',
        'gold',
        'thieving',
        'woodcutting',
        'tile_id',
        'building_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'is_admin',
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function addToInventory(Item $item)
    {
        $user = Auth::user();
        $user->items()->attach($item);

        return $user->items()->where('name', $item->name)->count();
    }

    public function removeFromInventory(Item $item)
    {
        $user = Auth::user();
        $retrievedItem = $user->items()->where('items.name', $item->name)->withPivot('id')->first();
        ItemUser::where('id', $retrievedItem->pivot->id)->update(['deleted_at' => now()]);
    }

    public function damage(int $damage): int
    {
        $user = Auth::user();
        $user->hitpoints -= $damage;
        $user->save();

        return $user->hitpoints;
    }

    public function addGold(int $amount)
    {
        $this->gold += $amount;
        $this->save();

        return $this->gold;
    }

    public function building()
    {
        return $this->hasOne(Building::class, 'id', 'building_id')->first();
    }

    public function tile()
    {
        return $this->hasOne(Tile::class, 'id', 'tile_id')->first();
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withTimestamps()->wherePivot('item_user.deleted_at', null)->groupBy('item_id')->selectRaw('items.*, count(item_id) as quantity');
    }
}
