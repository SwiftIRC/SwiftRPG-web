<?php

namespace App\Models;

use App\Models\Tile;
use Laravel\Sanctum\HasApiTokens;
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

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class);
    }

    public function inventory()
    {
        return $this->inventories()->first();
    }

    public function addToInventory(Item $item)
    {
        $inventory = $this->inventory();

        if (!$inventory) {
            $inventory = $this->inventories()->create([
                'user_id' => $this->id,
            ]);
        }

        $inventory->items()->attach($item);

        return $inventory->items()->where('name', $item->name)->count();
    }

    public function addGold(int $amount)
    {
        $inventory = $this->inventory();

        if (!$inventory) {
            $inventory = $this->inventories()->create([
                'user_id' => $this->id,
            ]);
        }

        $inventory->gold += $amount;
        $inventory->save();

        return $inventory->gold;
    }

    public function getGold()
    {
        $inventory = $this->inventories()->selectRaw('SUM(gold) as gold')->first();

        if (!$inventory) {
            return 0;
        }

        return $inventory->gold;
    }

    public function building()
    {
        return $this->hasMany(Building::class, 'id', 'building_id')->first();
    }

    public function tile()
    {
        return $this->hasMany(Tile::class, 'id', 'tile_id')->first();
    }
}
