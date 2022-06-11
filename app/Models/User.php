<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'thieving',
        'woodcutting',
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
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
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
}
