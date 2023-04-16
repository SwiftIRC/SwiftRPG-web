<?php

namespace App\Models;

use App\Models\ItemUser;
use App\Models\Skill;
use App\Models\Tile;
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
        'is_admin',
        'password',
        'hitpoints',
        'mana',
        'gold',
        'thieving',
        'woodcutting',
        'firemaking',
        'agility',
        'tile_id',
        'building_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function addXp(int $skill_id, int $xp)
    {
        $current = $this->skills()->where('skills.id', $skill_id)->withPivot('value')->first();

        if ($current === null) {
            $this->skills()->attach($skill_id, ['value' => $xp]);
            $this->save();

            return $xp;
        }

        $current->pivot->value += $xp;
        $current->pivot->save();

        return $current->pivot->value;
    }

    public function getXp(int $skill_id)
    {
        $current = $this->skills()->where('skills.id', $skill_id)->withPivot('value')->first();

        if ($current === null) {
            return 0;
        }

        return $current->pivot->value;
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('value');
    }

    public function addToInventory(Item $item, int $quantity = 1)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->items()->attach($item);
        }

        return $this->items()->where('name', $item->name)->count();
    }

    public function removeFromInventory(Item $item)
    {
        $retrievedItem = $this->items()->where('items.name', $item->name)->withPivot('id')->first();
        ItemUser::where('id', $retrievedItem->pivot->id)->update(['deleted_at' => now()]);
    }

    public function numberInInventory(Item $item)
    {
        return $this->items()->where('name', $item->name)->count();
    }

    public function inInventory(Item $item)
    {
        $retrievedItem = $this->items()->where('name', $item->name)->count();

        return ($retrievedItem > 0);
    }

    public function damage(int $damage): int
    {
        $this->hitpoints -= $damage;
        $this->save();

        return $this->hitpoints;
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

    public function quests()
    {
        return $this->hasOne(CompletedQuestStep::class)
            ->selectRaw('quests.*, count(quests.id) as completed, (SELECT count(quest_id) FROM quest_steps WHERE quest_id = quests.id) as total')
            ->leftJoin('quests', 'quests.id', '=', 'completed_quest_steps.quest_id')
            ->leftJoin('quest_steps', 'quest_steps.id', '=', 'completed_quest_steps.quest_step_id')
            ->groupBy('quests.id');
    }
}
