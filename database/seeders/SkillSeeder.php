<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::create(['name' => 'thieving']);
        Skill::create(['name' => 'fishing']);
        Skill::create(['name' => 'mining']);
        Skill::create(['name' => 'woodcutting']);
        Skill::create(['name' => 'firemaking']);
        Skill::create(['name' => 'cooking']);
        Skill::create(['name' => 'smithing']);
        Skill::create(['name' => 'fletching']);
        Skill::create(['name' => 'crafting']);
        Skill::create(['name' => 'herblore']);
        Skill::create(['name' => 'agility']);
        Skill::create(['name' => 'farming']);
        Skill::create(['name' => 'hunter']);
    }
}
